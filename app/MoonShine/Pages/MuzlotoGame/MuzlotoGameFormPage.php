<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\MuzlotoGame;

use Throwable;
use MoonShine\Fields\File;
use MoonShine\Fields\Text;
use MoonShine\MoonShineUI;
use App\Models\MuzlotoGame;
use MoonShine\Fields\Field;
use MoonShine\Fields\Hidden;
use MoonShine\Fields\Preview;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\MoonShineRequest;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Pages\Crud\FormPage;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Components\ActionGroup;
use MoonShine\Components\FormBuilder;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Components\MoonShineComponent;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MuzlotoGameFormPage extends FormPage
{
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {

        // return [
        //     Text::make('Название', 'name'),
        // ];

        $id = $this->getResource()->getItemID();

        return [

            Tabs::make([
                Tab::make('Генерация', [
                    Grid::make([

                        Column::make([

                            Block::make('Основные', [

                                FormBuilder::make($this->getResource()->route('crud.update', $id))
                                    ->async()
                                    ->fields([
                                        Hidden::make('_method')->fill('PUT')->hideOnForm(),

                                        Text::make('Название', 'name'),
                                        File::make('Шаблон билета')
                                    ])
                                    ->fillCast(MuzlotoGame::find($id), ModelCast::make(MuzlotoGame::class))

                            ])->customAttributes(['class' => 'mb-4']),

                            Block::make('Готовые файлы', [

                                ActionButton::make('Скачать')
                                    ->canSee(fn() => true)
                                    ->primary()
                                    ->icon('heroicons.outline.trash')
                                    ->showInLine(),
                            ])

                        ])->columnSpan(9),

                        Column::make([

                            Block::make('Билеты', [

                                Preview::make('Количество готовых билетов', 'name')

                            ])->customAttributes(['class' => 'mb-4']),

                            Block::make('Список песен', [])

                        ])->columnSpan(3),

                    ])
                ]),

                Tab::make('Игра', [
                    //...
                ])
            ])
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        $item = $this->getResource()->getItem();

        // dd($item);

        return [
            // ...parent::topLayer()
            ActionGroup::make([

                ActionButton::make('Сгенерировать')
                    ->method(
                        'generateTickets',
                        params: ['resourceItem' => $this->getResource()->getItemID()]
                    )
                    ->canSee(fn() => isset($item->id))
                    ->success(),

                // ActionButton::make('Перегененировать')
                //     ->canSee(fn() => true)
                //     ->error(),

                // ActionButton::make('Скачать')
                //     ->canSee(fn() => true)
                //     ->primary()
                //     ->icon('heroicons.outline.trash')
                //     ->showInLine(),

                ActionButton::make(
                    label: 'Нажми меня',
                    url: 'https://moonshine-laravel.com',
                )
                    ->inOffCanvas(
                        fn() => 'Заголовок боковой панели',
                        fn() => form()->fields([Text::make('Текст')]),
                        isLeft: false
                    )

            ])
                ->setItem($item)
                ->customAttributes(['class' => 'mb-4'])
        ];
    }

    // ->withConfirm(
    //     method: 'DELETE',
    //     formBuilder: fn (FormBuilder $formBuilder, Model $item) => $formBuilder->when(
    //         $isAsync || $resource->isAsync(),
    //         fn (FormBuilder $form): FormBuilder => $form->async(
    //             asyncEvents: $resource->listEventName(
    //                 $componentName ?? $resource->listComponentName(),
    //                 $isAsync ? array_filter([
    //                     'page' => request()->input('page'),
    //                     'sort' => request()->input('sort'),
    //                 ]) : []
    //             )
    //         )
    //     )
    // )
    // ->canSee(
    //     fn (?Model $item): bool => ! is_null($item) && in_array('delete', $resource->getActiveActions())
    //         && $resource->setItem($item)->can('delete')
    //

    // ->icon('heroicons.outline.trash')
    // ->showInLine();

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
        return $this->fields();
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
