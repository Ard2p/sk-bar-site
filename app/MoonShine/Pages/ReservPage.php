<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Event;
use App\Models\Reserv;
use MoonShine\Fields\Td;
use MoonShine\Pages\Page;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Text;
use MoonShine\Fields\Color;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use MoonShine\Enums\ToastType;
use App\Enums\ReservStatusEnum;
use App\Services\ReservService;
use MoonShine\Decorations\Grid;
use MoonShine\MoonShineRequest;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Support\Collection;
use MoonShine\Decorations\Heading;
use MoonShine\Decorations\Fragment;
use MoonShine\Components\ActionGroup;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\FlexibleRender;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Http\Responses\MoonShineJsonResponse;

class ReservPage extends Page
{
    protected ?string $alias = 'reserv';

    public function breadcrumbs(): array
    {
        return ['#' => $this->title()];
    }

    // public function beforeRender(): void
    // {
    //     if (auth()->user()->id !== 5) {
    //         abort(403);
    //     }
    // }

    public function components(): array
    {
        $events = $this->eventsItems();

        $eventsListButtons = [];
        foreach ($events as $event) {
            $eventsListButtons[] =  ActionButton::make(
                $event->guest_start->format('d.m'),
                fn() => $this->fragmentLoadUrl('event-reserv-fragment', ['id' => $event->getKey()])
            )->async(selector: '#event-reserv-fragment');
        }

        $event = $events->first();
        if (moonshineRequest()->filled('id')) {
            $event = Event::find(moonshineRequest()->id);
        }

        $reservService = new ReservService();
        $reservs = $reservService->show($event, true);

        return [

            Grid::make([

                Column::make([
                    ActionGroup::make($eventsListButtons),
                ]),

                Column::make([
                    Fragment::make([

                        Grid::make([

                            Column::make([
                                Block::make([
                                    Heading::make(htmlspecialchars_decode($event->name))->h(2),
                                    Heading::make($event->guest_start->format('d.m.Y'))->h(4),

                                    ActionButton::make('Печать', route('events.print', [$event]))->blank()->success()
                                        ->customAttributes(['style' => 'margin-bottom: 1.5rem;']),

                                    // FlexibleRender::make(view('reservs.admin', ['event' => $event]))

                                ]),
                            ])->customAttributes(['class' => 'col-span-12 2xl:col-span-4 xl:col-span-5 md:col-span-6']),

                            Column::make([
                                Block::make([
                                    TableBuilder::make($this->productlistFields(), $reservs)
                                        ->buttons([
                                            ActionButton::make('')->secondary()
                                                ->icon('heroicons.outline.pencil')
                                                ->inModal('Редактирование', fn($reserv) => $this->productForm($reserv, $event->id))
                                        ])
                                        ->name('rk-product-list')
                                ])
                            ])->customAttributes(['class' => 'col-span-12 2xl:col-span-8 xl:col-span-7 md:col-span-6']),

                        ]),
                    ])->name('event-reserv-fragment')->customAttributes(['id' => 'event-reserv-fragment'])
                ])

            ]),

            $this->styles()
        ];
    }

    private function eventsItems(): Collection
    {
        return Event::skbar()->get();
    }

    private function productListFields(): array
    {
        return [
            Text::make('Стол', 'name'),
            Text::make('Гостей', 'seats'),
            Text::make('ФИО', 'fio'),
            Text::make('Телефон', 'phone'),

            Td::make('Статус', function ($data) {
                return [
                    Color::make('Статус', 'color')->changePreview(fn() => view('moonshine::fields.color', [
                        'color' => $data['color'],
                        'status' => ReservStatusEnum::from($data['status'])->toString(),
                    ]))
                ];
            })
        ];
    }

    private function productForm($reserv = null, $eventId): FormBuilder
    {
        return FormBuilder::make()
            ->name('rk-product-form')
            ->fill($reserv)
            ->fields([
                Hidden::make(column: 'id'),
                Hidden::make(column: 'name'),
                Hidden::make(column: 'event_id')->fill($eventId),

                Enum::make(__('Status'), 'status')->attach(ReservStatusEnum::class)->required(),

                Text::make('ФИО', 'fio'),
                Text::make('Телефон', 'phone')->mask("+7 (999) 999-99-99"),
                Number::make('Гостей', 'seats'),
            ])
            ->asyncMethod('productFormSave', events: $this->productUpdateEvents($eventId))
            ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    }

    public function productFormSave(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->merge([
            'seats' =>  $request->get('seats') ?? 0,
        ]);

        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $reserve = Reserv::where('event_id', $request->get('event_id'))->where('table', $request->get('name'))->first();
        if ($reserve && $reserve->id != $request->get('id')) return MoonShineJsonResponse::make()->toast('Этот стол уже занят!', ToastType::ERROR);

        if ($request->get('status') == ReservStatusEnum::FREE->value) {
            if ($reserve) $reserve->delete();
        } else {
            Reserv::updateOrCreate(['id' => $request->get('id')], [
                'event_id' => $request->get('event_id'),
                'table' => $request->get('name'),
                'name' => $request->get('fio'),
                'phone' => $request->get('phone'),
                'seats' => $request->get('seats'),
                'status' => $request->get('status'),
            ]);
        }

        return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    }

    private function productUpdateEvents($eventId): array
    {
        return [
            AlpineJs::event(JsEvent::FRAGMENT_UPDATED, 'event-reserv-fragment', ['id' => $eventId]),
            AlpineJs::event(JsEvent::FORM_RESET, 'rk-product-form'),
        ];
    }

    private function styles(): FlexibleRender
    {
        return FlexibleRender::make(<<<'HTML'
        <style>
            .table-list th,
            .table-list td {padding:0!important;height:38px!important;}
            .table-list th:not(:last-child),
            .table-list td:not(:last-child){padding-right:0.5rem!important;}
            .table-list td .btn-link{white-space:normal!important;}
            .btn-link {
                width:100%;
                padding: 0;
                border:none!important;
                justify-content:start;
                max-height:38px!important;
                min-height:inherit!important;
                background:inherit!important;
            }
            .btn-link:focus-visible {outline:none!important;}
            .btn-link:focus {box-shadow:none!important;}
            .badge-skbar {background:#f9322c!important;color:white;font-weight:bold;border-radius:.85rem}
        </style>
        HTML);
    }
}
