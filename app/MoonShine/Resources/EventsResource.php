<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Event;
use MoonShine\Fields\ID;

use MoonShine\Pages\Page;
use MoonShine\Fields\Date;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Json;
use MoonShine\Fields\Slug;
use MoonShine\Fields\Text;
use App\Enums\AgeLimitEnum;
use MoonShine\Fields\Field;
use MoonShine\Fields\Image;
use MoonShine\Fields\Fields;
use MoonShine\Fields\Select;
use MoonShine\MoonShineAuth;
use MoonShine\Fields\Preview;
use MoonShine\Fields\TinyMce;
use App\Enums\EventStatusEnum;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Checkbox;
use MoonShine\Fields\Password;
use MoonShine\Fields\Switcher;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use Illuminate\Support\Collection;
use MoonShine\Decorations\Heading;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Components\FormBuilder;
use MoonShine\Layouts\Fields\Layouts;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use MoonShine\Components\FlexibleRender;
use App\MoonShine\Resources\PlacesResource;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Http\Controllers\ProfileController;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

/**
 * @extends ModelResource<Event>
 */
class EventsResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Event::class;

    protected string $title = 'Афиша';

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
            'restore',
            'forceDelete',
        ];
    }

    public function formFields(): array
    {
        return [
            Grid::make([
                Column::make([
                    Block::make([

                        ID::make()->sortable(),
                        Text::make(__('Title'), 'name')->required(),
                        // Slug::make(__('Slug'), 'slug')->from('name')->separator('-')->unique(),
                        TinyMce::make(__('Description'), 'description'),

                        // Json::make('Социальные сети', 'gallery')
                        //     ->fields([
                        //         Select::make(__('Age limit'))
                        //             ->options([
                        //                 'vk' => 'vk',
                        //                 'instagram' => 'instagram',
                        //             ])
                        //             ->default('vk')
                        //             ->required(),
                        //         Text::make('Value', 'value')
                        //     ])->removable()->hideOnIndex(),

                        // Layouts::make('Content')
                        //     ->addLayout('Contact information', 'gallery', [
                        //         Text::make('Name'),
                        //         Text::make('Name'),
                        //     ]),

                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([

                        Flex::make([
                            Enum::make(__('Status'), 'status')
                                ->attach(EventStatusEnum::class)
                                ->default(EventStatusEnum::DRAFT->name)
                                ->required(),

                            Enum::make(__('Age limit'), 'age_limit')
                                ->attach(AgeLimitEnum::class)
                                ->default(AgeLimitEnum::AGE_0->name)
                                ->required(),
                        ]),

                        Flex::make([
                            Date::make(__('Event start'), 'event_start')->withTime()->required(),
                            Date::make(__('Guest start'), 'guest_start')->withTime()->required(),
                        ]),

                        BelongsTo::make(__('Place event'), 'place', fn ($item) => "$item->name, $item->city")->searchable(),
                        Switcher::make(__('Recommendation'), 'recommendation')->default(false),

                        Image::make(__('Image'), 'image')->when(
                            fn ($field) => $field->isNowOnCreateForm(),
                            fn ($field) => $field->required()
                        )
                            ->disk(config('moonshine.disk', 'public'))->dir('events')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'webp']),

                        // Image::make(__('Gallery'), 'gallery')
                        //     ->multiple()
                        //     ->removable()
                        //     ->disk(config('moonshine.disk', 'public'))
                        //     ->dir('events')
                        //     ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'webp'])
                        //     ->when(
                        //         fn ($field) => $field->isNowOnCreateForm(),
                        //         fn ($field) => $field->required()
                        //     )

                    ])
                ])->columnSpan(4),
            ]),
        ];
    }

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Image::make(__('Image'), 'image'),
            Text::make(__('Title'), 'name')->sortable(),
            Enum::make(__('Age'), 'age_limit')->attach(AgeLimitEnum::class)->sortable(),
            Enum::make(__('Status'), 'status')->attach(EventStatusEnum::class)->sortable(),
            Date::make(__('Event start'), 'event_start')->format('d.m H.i')->sortable(),
            Date::make(__('Guest start'), 'guest_start')->format('d.m H.i')->sortable(),
            BelongsTo::make(__('Place event'), 'place', fn ($item) => "$item->name, $item->city")->sortable(),
            Switcher::make('⭐️', 'recommendation')->sortable(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Image::make(__('Image'), 'image'),
            Text::make(__('Title'), 'name'),
            Enum::make(__('Age limit'), 'age_limit')->attach(AgeLimitEnum::class),
            Enum::make(__('Status'), 'status')->attach(EventStatusEnum::class),
            Date::make(__('Event start'), 'event_start')->format('d.m H.i'),
            Date::make(__('Guest start'), 'guest_start')->format('d.m H.i'),
            BelongsTo::make(__('Place event'), 'place', fn ($item) => "$item->name, $item->city"),
            Switcher::make(__('Recommendation'), 'recommendation'),
            TinyMce::make(__('Description'), 'description'),
        ];
    }

    public function rules(Model $item): array
    {
        // dd( moonshineRequest()->all());

        return [
            'image' => 'exclude_with:hidden_image|required',
        ];
    }
}
