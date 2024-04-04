<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Event;
use MoonShine\Fields\ID;

use MoonShine\Pages\Page;
use MoonShine\Fields\Date;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\MoonShineAuth;
use MoonShine\Fields\TinyMce;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Heading;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Components\FormBuilder;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\FlexibleRender;
use MoonShine\Http\Controllers\ProfileController;

/**
 * @extends ModelResource<Event>
 */
class EventsResource extends ModelResource
{
    protected string $model = Event::class;

    protected string $title = 'Афиша';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function fields(): array
    {
        return [
            Grid::make([

                Column::make([
                    Block::make([

                        ID::make()->sortable(),

                        Text::make(__('Title'), 'name')
                            ->required(),


                        Date::make(__('Date start'), 'date_start')
                            ->withTime()
                            ->required(),

                        Image::make(__('Image'), 'image')
                            ->removable()
                            ->allowedExtensions(['png', 'jpg', 'webp'])
                            ->required(),

                    ])
                ])->columnSpan(6),

                Column::make([
                    Block::make([

                        Select::make(__('Status'), 'status')
                            ->options([
                                'draft' => 'Черновик',
                                'publish' => 'Опубликован'
                            ])
                            ->default('draft')
                            ->required(),

                        Select::make(__('Age limit'), 'age_limit')
                            ->options([
                                '0' => '0+',
                                '6' => '6+',
                                '12' => '12+',
                                '16' => '16+',
                                '18' => '18+'
                            ])
                            ->hideOnIndex()
                            ->default(0)
                            ->required(),

                        Select::make(__('City'), 'city_id')
                            ->options([
                                '1' => 'Чебоксары',
                                '2' => 'Казань'
                            ])
                            ->default(1)
                            ->required(),

                        Text::make(__('Adress'), 'adress')
                            ->hideOnIndex()
                            ->required(),

                    ])
                ])->columnSpan(6),

                Column::make([
                    Block::make([

                        TinyMce::make(__('Description'), 'description')
                            ->hideOnIndex(),

                    ]),
                ]),
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
