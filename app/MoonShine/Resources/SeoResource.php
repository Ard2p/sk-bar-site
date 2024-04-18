<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Seo;
use App\Models\Place;

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
use MoonShine\Fields\Switcher;
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
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

/**
 * @extends ModelResource<Event>
 */
class SeoResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Seo::class;

    protected string $title = 'Seo';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([
                        ID::make()->sortable()->hideOnIndex(),
                        Text::make(__('Url'), 'url'),
                        Text::make(__('Seo'), 'seo')->hideOnIndex(),
                    ])
                ])
            ])
        ];
    }

    public function getMorphFields(): array
    {
        return [
            Column::make([
                ID::make(),
                Text::make(__('Url'), 'url'),
                Text::make(__('Seo'), 'seo')
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }
}
