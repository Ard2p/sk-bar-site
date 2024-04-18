<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Page;
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
 * @extends ModelResource<Page>
 */
class PageResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Page::class;

    protected string $title = 'Страницы';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([

                        ID::make()->sortable(),
                        Text::make(__('Title'), 'name')->required(),
                        Text::make(__('Slug'), 'slug')->required(),
                        Text::make(__('Status'), 'status')->required(),
                        Number::make(__('Parent_id'), 'parent_id')->required(),
                        TinyMce::make(__('Title'), 'content')->required()

                    ])
                ])
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
