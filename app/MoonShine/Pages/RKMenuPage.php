<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Pages\Page;
use App\Models\RKCategory;
use MoonShine\Fields\Text;
use MoonShine\Enums\JsEvent;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Preview;
use MoonShine\Components\Icon;
use MoonShine\Components\Link;
use MoonShine\Enums\ToastType;
use MoonShine\Fields\Position;
use MoonShine\Decorations\Grid;
use MoonShine\MoonShineRequest;
use MoonShine\Support\AlpineJs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Fields\StackFields;
use MoonShine\QueryTags\QueryTag;
use Illuminate\Support\Collection;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Decorations\Fragment;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\TableBuilder;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\ActionButtons\ActionButton;
use Illuminate\View\ComponentAttributeBag;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Http\Responses\MoonShineJsonResponse;

class RKMenuPage extends Page
{

    protected ?string $alias = 'rk-menu';

    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Catalog';
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        return [
            Grid::make([

                Column::make([
                    Block::make([
                        TableBuilder::make(fields: $this->listFields())
                            ->tdAttributes(
                                fn (mixed $data, int $row, int $cell, ComponentAttributeBag $attr) =>
                                $attr->merge(['style' => 'padding-top: 0;padding-bottom: 0;'])
                            )
                            ->name('rk-categories-list')
                            ->cast(ModelCast::make(RKCategory::class))
                            ->items($this->items())
                            ->async()
                            ->sortable($this->asyncMethodUrl('reorder'), 'ident')
                            ->reindex()
                            ->withNotFound()
                            ->buttons([
                                ActionButton::make('')
                                    ->secondary()
                                    ->icon('heroicons.outline.pencil')
                                    ->inModal('Редактирование', fn (RKCategory $category) => $this->formComponent($category))
                            ])
                    ])
                ])->columnSpan(3),

                Column::make([
                    Block::make([

                        // Fragment::make([
                        //     TableBuilder::make(fields: $this->listFields())
                        //         ->tdAttributes(
                        //             fn (mixed $data, int $row, int $cell, ComponentAttributeBag $attr) =>
                        //             $attr->merge(['style' => 'padding-top: 0;padding-bottom: 0;'])
                        //         )
                        //         ->name('rk-categories-list')
                        //         ->cast(ModelCast::make(RKCategory::class))
                        //         ->items($this->items())
                        //         ->async()
                        //         ->sortable($this->asyncMethodUrl('reorder'), 'ident')
                        //         ->reindex()
                        //         ->withNotFound()
                        //         ->buttons([
                        //             ActionButton::make('')
                        //                 ->secondary()
                        //                 ->icon('heroicons.outline.pencil')
                        //                 ->inModal('Редактирование', fn (RKCategory $category) => $this->formComponent($category))
                        //         ])
                        // ])->name('fragment-name')

                    ])
                ])->columnSpan(9)
            ])
        ];
    }

    private function formFields(): array
    {
        return [
            Hidden::make(column: 'ident'),
            Text::make('Категория', 'name')
        ];
    }

    private function formComponent(?RKCategory $category = null): FormBuilder
    {
        return FormBuilder::make()
            ->name('rk-categories-form')
            ->fields($this->formFields())
            ->fillCast($category, ModelCast::make(RKCategory::class))
            ->asyncMethod('save', events: $this->updateListingEvents())
            ->submit('Обновить', ['class' => 'btn-primary btn-lg']);
    }

    public function save(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->validate(['name' => ['required', 'string']]);

        RKCategory::where('ident', $request->integer('ident'))->update([
            'name' => $request->get('name'),
        ]);

        return MoonShineJsonResponse::make()->toast('Обновленно', ToastType::SUCCESS);
    }

    private function updateListingEvents(): array
    {
        return [
            AlpineJs::event(JsEvent::TABLE_UPDATED, 'rk-categories-list'),
            AlpineJs::event(JsEvent::FORM_RESET, 'rk-categories-form'),
        ];
    }

    private function items(): Collection
    {
        return RKCategory::query()->orderBy('position')->get();
    }

    private function listFields(): array
    {
        // dd($this->getItem());

        return [
            Text::make('Категория', 'name'),

            // dd($this->getItem())
            // ActionButton::make(fn($var) => dd($var))


            // ->link(
            //     fn ($value, Text $field) => to_page(page: CatalogPage::class) . '/' . $field->getData()->ident,
            //     withoutIcon: true
            // )
        ];
    }

    public function reorder(MoonShineRequest $request): MoonShineJsonResponse
    {
        $request->string('data')->explode(',')->each(
            fn (string $id, int $sortOrder) =>
            RKCategory::where('ident', $id)?->update(['position' => $sortOrder])
        );

        return MoonShineJsonResponse::make()->toast('Позиция обновлена', ToastType::SUCCESS);
    }
}
