<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Event;
use App\Models\Reserv;
use MoonShine\Fields\Td;
use App\Models\RKProduct;
use MoonShine\Pages\Page;
use App\Models\RKCategory;
use MoonShine\Fields\Text;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use App\Jobs\RKCatalogUpdate;
use MoonShine\Fields\Preview;
use MoonShine\Enums\ToastType;
use MoonShine\Fields\Position;
use App\Enums\ReservStatusEnum;
use App\Enums\ReservTablesEnum;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\MoonShineRequest;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Fields\StackFields;
use MoonShine\QueryTags\QueryTag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use MoonShine\Decorations\Heading;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Decorations\Fragment;
use MoonShine\Components\ActionGroup;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\FlexibleRender;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Fields\Color;
use MoonShine\Http\Responses\MoonShineJsonResponse;

class ReservPage extends Page
{
    protected ?string $alias = 'reserv';

    public function breadcrumbs(): array
    {
        return ['#' => $this->title()];
    }

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

        $reservsDB = Reserv::where('event_id', $event->id)->get()->keyBy('table');

        $reservs = [];
        $tableListButtons = [];
        foreach (ReservTablesEnum::cases() as $table) {

            $tableDB = $reservsDB->get($table->value);

            if ($tableDB) {
                $status = ReservStatusEnum::from($tableDB->status);
            }

            $tableListButtons[] =  ActionButton::make(
                $table->toString(),
                fn() => $this->fragmentLoadUrl('event-reserv-fragment', ['table' => $table->value])
            )
                ->primary()->customAttributes(['style' => '--primary: 20, 167, 233;'])
                ->async(selector: '#event-reserv-fragment');

            $reservs[$table->value] = [
                'id' => $tableDB ? $tableDB->id : null,
                'name' => $table->toString(),
                'price' => $table->price(),
                'color' => $tableDB ? $status->getColorNotFree() : $table->color(),
                'status' => $tableDB ? $status->value : ReservStatusEnum::FREE->value,
                'fio' => $tableDB ? $tableDB->name : null,
                'seats' => $tableDB ? $tableDB->seats : null,
                'phone' => $tableDB ? $tableDB->phone : null,
            ];
        }

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
                                    Heading::make($event->name)->h(2),
                                    Heading::make($event->guest_start->format('d.m'))->h(4),
                                    // ActionGroup::make($tableListButtons),
                                ]),
                            ])->customAttributes(['class' => 'col-span-12 2xl:col-span-4 xl:col-span-5 md:col-span-6']),

                            Column::make([
                                Block::make([
                                    // FlexibleRender::make(view('reservs.admin', ['event' => $event]))

                                    TableBuilder::make($this->productlistFields(), $reservs)
                                        // ->sortable($this->asyncMethodUrl('productReorder'), 'table')->reindex()->async()
                                        // ->buttons([
                                        //     ActionButton::make('')->secondary()
                                        //         ->icon('heroicons.outline.pencil')
                                        //         ->inModal('Редактирование', fn($reserv) => $this->productForm($reserv))
                                        // ])
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
        return Event::active()
            // ->actual()
            ->orderBy('event_start')->get();
    }

    private function productListFields(): array
    {
        return [
            Text::make('Стол', 'name'),
            Text::make('Гостей', 'seats'),
            Text::make('ФИО', 'fio'),
            Text::make('Телефон', 'phone'),
            // Text::make('Статус', 'status'),
            // Color::make('Статус', 'color')
        ];
    }

    private function productForm($reserv = null): FormBuilder
    {
        return FormBuilder::make()
            ->name('rk-product-form')
            ->fill($reserv)
            ->fields($this->productFormFields())
            ->asyncMethod('productFormSave', events: $this->productUpdateEvents())
            ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    }

    private function productFormFields(): array
    {
        return [
            Hidden::make(column: 'id'),

            Text::make('ФИО', 'fio'),
            Text::make('Телефон', 'phone'),
            Number::make('Гостей', 'seats'),
        ];
    }

    public function productFormSave(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->validate(['fio' => ['required', 'string']]);

        Reserv::where('id', $request->get('id'))->update([
            'name' => $request->get('fio'),
        ]);

        return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    }

    private function productUpdateEvents(): array
    {
        return [
            AlpineJs::event(JsEvent::TABLE_UPDATED, 'rk-product-list'),
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
