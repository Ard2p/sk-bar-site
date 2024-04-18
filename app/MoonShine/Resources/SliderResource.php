<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Place;
use App\Models\Slider;

use MoonShine\Fields\ID;
use MoonShine\Fields\Date;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\Fields\TinyMce;
use App\Enums\SliderStatusEnum;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

/**
 * @extends ModelResource<Event>
 */
class SliderResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Slider::class;

    protected string $title = 'Слайдер';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function gateAbilities(): array
    {
        return [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'massDelete',
            // 'restore',
            // 'forceDelete',
        ];
    }

    public function fields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([

                        ID::make()->sortable(),
                        Text::make(__('Title'), 'name')->required()->sortable(),

                        Image::make(__('Image'), 'image')->when(
                            fn ($field) => $field->isNowOnCreateForm(),
                            fn ($field) => $field->required()
                        )
                            ->disk(config('moonshine.disk', 'public'))->dir('slider')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'webp']),

                        Text::make(__('Link'), 'link'),

                        Enum::make(__('Status'), 'status')
                            ->attach(SliderStatusEnum::class)
                            ->default(SliderStatusEnum::DRAFT->name)
                            ->placeholder('-')
                            ->nullable()
                            ->required(),

                        Flex::make([
                            Date::make(__('Date from'), 'date_from')->withTime(),
                            Date::make(__('Date to'), 'date_to')->withTime(),
                        ]),

                    ])
                ])
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'image' => 'exclude_with:hidden_image|required',
        ];
    }
}
