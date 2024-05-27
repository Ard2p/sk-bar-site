<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Fields\Td;
use App\Models\RKProduct;
use MoonShine\Pages\Page;
use App\Models\RKCategory;
use MoonShine\Fields\Text;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Number;
use App\Jobs\RKCatalogUpdate;
use MoonShine\Enums\ToastType;
use MoonShine\Fields\Position;
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
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Decorations\Fragment;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use MoonShine\Components\FlexibleRender;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Http\Responses\MoonShineJsonResponse;

class RKMenuPage extends Page
{
    protected ?string $alias = 'rk-menu';

    public function breadcrumbs(): array
    {
        return ['#' => $this->title()];
    }

    public function components(): array
    {
        return [
            Grid::make([

                Column::make([
                    Block::make([
                        // Column::make([]),
                        // Column::make([
                        ActionButton::make('Обновить меню')->success()
                            ->method('menuUpdate')
                            ->icon('heroicons.outline.arrow-path')
                            ->customAttributes(['class' => 'col-start-auto'])
                        // ])
                    ])
                ]),

                Column::make([
                    Block::make([
                        TableBuilder::make($this->categorylistFields(), $this->categoryItems())
                            ->cast(ModelCast::make(RKCategory::class))->withNotFound()
                            ->sortable($this->asyncMethodUrl('categoryReorder'), 'ident')->reindex()->async()
                            ->buttons([
                                // ActionButton::make('')->secondary()
                                //     ->icon('heroicons.outline.pencil')
                                //     ->inModal('Редактирование', fn (RKCategory $category) => $this->categoryForm($category))
                            ])
                            ->name('rk-categories-list')
                    ])
                ])->customAttributes(['class' => 'col-span-12 2xl:col-span-3 xl:col-span-5 md:col-span-6']),

                Column::make([
                    Block::make([
                        Fragment::make([
                            TableBuilder::make($this->productlistFields(), $this->productItems())
                                ->cast(ModelCast::make(RKProduct::class))->withNotFound()
                                ->sortable($this->asyncMethodUrl('productReorder'), 'ident')->reindex()->async()
                                ->buttons([
                                    // ActionButton::make('')->secondary()
                                    //     ->icon('heroicons.outline.pencil')
                                    //     ->inModal('Редактирование', fn (RKProduct $product) => $this->productForm($product))
                                ])
                                ->name('rk-products-list')
                        ])->name('rk-products-fragment')->customAttributes(['id' => 'rk-products-fragment'])
                    ])
                ])->customAttributes(['class' => 'col-span-12 2xl:col-span-9 xl:col-span-7 md:col-span-6']),

            ]),

            $this->styles()
        ];
    }

    private function productItems(): Collection
    {
        if (moonshineRequest()->filled('ident')) {
            return RKProduct::where('parent_ident', moonshineRequest()->ident)->order()->get();
        }

        return RKProduct::select('rk_products.*')
            ->join('rk_categories', 'rk_products.parent_ident', '=', 'rk_categories.ident')
            ->orderBy('rk_categories.position')->order()
            ->get();
    }

    private function productListFields(): array
    {
        return [
            // Position::make(),

            Text::make('Позиция', 'name'),

            Number::make('Цена', 'price', fn ($item) => ($item->price / 100) . 'р')->badge('primary')
        ];
    }

    private function productFormFields(): array
    {
        return [
            Hidden::make(column: 'ident'),
            Text::make('Категория', 'name')->readonly(),
            Number::make('Цена', 'price', fn ($item) => ($item->price / 100) . 'р')->readonly(),
        ];
    }

    private function productForm(?RKProduct $product = null): FormBuilder
    {
        return FormBuilder::make()
            ->name('rk-categories-form')
            ->fields($this->productFormFields())
            ->fillCast($product, ModelCast::make(RKProduct::class))
            ->asyncMethod('productFormSave', events: $this->productUpdateEvents())
            ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    }

    public function productFormSave(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->validate(['name' => ['required', 'string']]);

        RKProduct::where('ident', $request->integer('ident'))->update([
            'name' => $request->get('name'),
        ]);

        return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    }

    public function productReorder(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->string('data')->explode(',')->each(
            fn (string $id, int $sortOrder) =>
            RKProduct::where('ident', $id)?->update(['position' => $sortOrder])
        );

        return MoonShineJsonResponse::make()->toast('Позиция обновлена', ToastType::SUCCESS);
    }

    private function productUpdateEvents(): array
    {
        return [
            AlpineJs::event(JsEvent::TABLE_UPDATED, 'rk-product-list'),
            AlpineJs::event(JsEvent::FORM_RESET, 'rk-product-form'),
        ];
    }

    private function categoryItems(): Collection
    {
        return RKCategory::order()->get();
    }

    private function categoryListFields(): array
    {
        // $categoryCount = RKCategory::count();
        return [
            // Position::make(),

            Td::make('Категория', fn (RKCategory $category) => [

                // StackFields::make('Title')->fields([
                ActionButton::make(
                    $category->name,
                    fn () => $this->fragmentLoadUrl('rk-products-fragment', ['ident' => $category->getKey()])
                )->async(selector: '#rk-products-fragment')->customAttributes(['class' => 'btn-link']),

                // Number::make(formatted: fn($category) => $category->products->count())->badge('skbar')
                // ])
            ])
        ];
    }

    private function categoryFormFields(): array
    {
        return [
            Hidden::make(column: 'ident'),
            Text::make('Категория', 'name')
        ];
    }

    private function categoryForm(?RKCategory $category = null): FormBuilder
    {
        return FormBuilder::make()
            ->name('rk-categories-form')
            ->fields($this->categoryFormFields())
            ->fillCast($category, ModelCast::make(RKCategory::class))
            ->asyncMethod('categoryFormSave', events: $this->categoryUpdateEvents())
            ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    }

    public function categoryFormSave(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->validate(['name' => ['required', 'string']]);

        RKCategory::where('ident', $request->integer('ident'))->update([
            'name' => $request->get('name'),
        ]);

        return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    }

    public function categoryReorder(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->string('data')->explode(',')->each(
            fn (string $id, int $sortOrder) =>
            RKCategory::where('ident', $id)?->update(['position' => $sortOrder])
        );

        return MoonShineJsonResponse::make()->toast('Позиция обновлена', ToastType::SUCCESS);
    }

    private function categoryUpdateEvents(): array
    {
        return [
            AlpineJs::event(JsEvent::TABLE_UPDATED, 'rk-categories-list'),
            AlpineJs::event(JsEvent::FORM_RESET, 'rk-categories-form'),
        ];
    }

    public function menuUpdate(MoonShineRequest $request)
    {
        RKCatalogUpdate::dispatch();
        return MoonShineJsonResponse::make()->toast('Задание на обновление добавленно! Ждите.', ToastType::SUCCESS);
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
