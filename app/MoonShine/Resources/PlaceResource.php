<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Place;
use MoonShine\Fields\ID;

use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\TinyMce;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

/**
 * @extends ModelResource<Event>
 */
class PlaceResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Place::class;

    protected string $title = 'Места проведения';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([

                        ID::make()->sortable(),
                        Text::make(__('Title'), 'name')->required()->sortable(),
                        Text::make(__('City'), 'city')->required()->sortable(),
                        Text::make(__('Adress'), 'adress')->required(),
                        TinyMce::make(__('Content'), 'content')->hideOnIndex(),
                        Text::make(__('Map'), 'map')->hideOnIndex(),

                    ])
                ])
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
