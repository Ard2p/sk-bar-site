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
                fn () => $this->fragmentLoadUrl('event-reserv-fragment', ['id' => $event->getKey()])
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
                fn () => $this->fragmentLoadUrl('event-reserv-fragment', ['table' => $table->value])
            )
                ->primary()->customAttributes(['style' => '--primary: 20, 167, 233;'])
                ->async(selector: '#event-reserv-fragment');

            $reservs[$table->value] = [
                'name' => $table->toString(),
                'price' => $table->price(),
                'color' => $tableDB ? $status->getColorNotFree() : $table->color(),
                'status' => $tableDB ? $status->value : ReservStatusEnum::FREE->value
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
                                    ActionGroup::make($tableListButtons),
                                ]),
                            ])->customAttributes(['class' => 'col-span-12 2xl:col-span-4 xl:col-span-5 md:col-span-6']),

                            Column::make([
                                Block::make([
                                    FlexibleRender::make(view('reservs.admin', ['event' => $event]))
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

    private function eventsListFields(): array
    {
        return [
            Td::make('Даты мероприятий', fn (Event $event) => [
                ActionButton::make(
                    $event->guest_start->format('d.m'),
                    fn () => $this->fragmentLoadUrl('event-reserv-fragment', ['id' => $event->getKey()])
                )->async(selector: '#event-reserv-fragment'),
                // ->customAttributes(['class' => 'btn-link'])
            ])
        ];
    }

    // private function productItems(): Collection
    // {
    //     if (moonshineRequest()->filled('ident')) {
    //         return RKProduct::where('parent_ident', moonshineRequest()->ident)->order()->get();
    //     }

    //     return RKProduct::select('rk_products.*')
    //         ->join('rk_categories', 'rk_products.parent_ident', '=', 'rk_categories.ident')
    //         ->orderBy('rk_categories.position')->order()
    //         ->get();
    // }

    // private function productListFields(): array
    // {
    //     return [
    //         // Position::make(),

    //         Text::make('Позиция', 'name'),

    //         Number::make('Цена', 'price', fn ($item) => ($item->price / 100) . 'р')->badge('primary')
    //     ];
    // }

    // private function productFormFields(): array
    // {
    //     return [
    //         Hidden::make(column: 'ident'),
    //         Hidden::make(column: 'name'),
    //         Hidden::make(column: 'price'),

    //         Text::make('Наименование', 'name')->disabled(),
    //         Number::make('Цена', 'price', fn ($item) => ($item->price / 100) . 'р')->disabled()
    //     ];
    // }

    // private function productForm(?RKProduct $product = null): FormBuilder
    // {
    //     return FormBuilder::make()
    //         ->name('rk-product-form')
    //         ->fields($this->productFormFields())
    //         ->fillCast($product, ModelCast::make(RKProduct::class))
    //         ->asyncMethod('productFormSave', events: $this->productUpdateEvents())
    //         ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    // }

    // public function productFormSave(MoonShineRequest $request): MoonShineJsonResponse
    // {
    //     $request->validate(['name' => ['required', 'string']]);

    //     RKProduct::where('ident', $request->integer('ident'))->update([
    //         'name' => $request->get('name'),
    //     ]);

    //     return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    // }



    // private function productUpdateEvents(): array
    // {
    //     return [
    //         AlpineJs::event(JsEvent::TABLE_UPDATED, 'rk-product-list'),
    //         AlpineJs::event(JsEvent::FORM_RESET, 'rk-product-form'),
    //     ];
    // }

    // public function menuUpdate(MoonShineRequest $request)
    // {
    //     RKCatalogUpdate::dispatch();
    //     return MoonShineJsonResponse::make()->toast('Задание на обновление добавленно! Ждите.', ToastType::SUCCESS);
    // }

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
