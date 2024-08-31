<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Seo;
use App\Models\Event;
use MoonShine\Fields\ID;
use MoonShine\Fields\Td;
use MoonShine\Fields\Code;
use MoonShine\Fields\Date;
use MoonShine\Fields\Enum;
use MoonShine\Fields\Json;
use MoonShine\Fields\Text;
use App\Enums\AgeLimitEnum;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\Fields\Preview;
use MoonShine\Fields\TinyMce;
use App\Enums\EventStatusEnum;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Template;
use MoonShine\Fields\Textarea;
use App\Enums\ReservStatusEnum;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\QueryTags\QueryTag;
use MoonShine\Components\Components;
use MoonShine\Components\TableBuilder;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\FlexibleRender;
use Illuminate\Database\Eloquent\Builder;
use MoonShine\Fields\Relationships\BelongsTo;
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
            // 'restore',
            // 'forceDelete',
        ];
    }

    public function queryTags(): array
    {
        return [
            QueryTag::make('Актуальные', fn(Builder $query) => $query->actual())->alias('actual')->default(),
            QueryTag::make('Архив', fn(Builder $query) => $query->arhive())->alias('arhive'),
            QueryTag::make('Все', fn(Builder $query) => $query)->alias('all')
        ];
    }

    protected function resolveOrder(): static
    {
        if (request('query-tag') == 'actual') {
            $this->query()->orderBy('event_start', 'ASC');
            return $this;
        }

        return parent::resolveOrder();
    }

    public function formFields(): array
    {
        return [
            FlexibleRender::make(<<<'HTML'
                <style>
                    .height-code { min-height: 654px; }
                    /* tr>th:first-child,tr>td:first-child {
                        width: 70px;
                    } */
                </style>
            HTML),
            Grid::make([
                Column::make([
                    Block::make([
                        Tabs::make([

                            Tab::make('Основное', [
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
                            ]),

                            Tab::make('Билеты', [
                                Text::make(__('Tickets link'), 'tickets_link'),
                            ]),

                            Tab::make('Бронирование', [
                                Column::make([

                                    Switcher::make(__('Включить'), 'on_reserve')->xModel('on_reserve')->default(true),

                                    // TableBuilder::make()->xIf('on_reserve', '1')
                                    //     ->fields([

                                    //         Td::make('№', function ($data) {
                                    //             return [
                                    //                 Preview::make('№', 'name')->fill('1'),
                                    //             ];
                                    //         })->customAttributes(['style' => 'width: 70px;']),

                                    //         // Td::make('№',[
                                    //         //     Preview::make('№', 'name')->fill('1'),
                                    //         // ])->customAttributes(['style' => 'width: 70px;']),

                                    //         Select::make('Статус', 'status')->options([
                                    //             ReservStatusEnum::FREE->value => ReservStatusEnum::FREE->toString(),
                                    //             ReservStatusEnum::RESERV->value => ReservStatusEnum::RESERV->toString(),
                                    //             ReservStatusEnum::REMOVED->value => ReservStatusEnum::REMOVED->toString(),
                                    //         ])
                                    //     ])
                                    //     ->items([
                                    //         [
                                    //             'name' => '1',
                                    //             'status' =>  ReservStatusEnum::REMOVED->value
                                    //         ]
                                    //     ])->editable()
                                    // ->reorderable(false)
                                    // ->customAttributes(['style' => 'width: 300px;'])
                                    // ->creatable(false)

                                ])->xData([
                                    'on_reserve' => '1'
                                ]),
                            ]),

                            Tab::make('Метрика', [
                                Code::make('Код для вставки', 'metrics')
                                    ->language('js')
                                    ->lineNumbers()
                                    ->customAttributes(['class' => 'height-code']),
                            ]),

                            Tab::make(__('Seo'), [
                                Template::make(column: 'seo')
                                    ->changeFill(fn(Event $data) => $data->seo)
                                    ->changePreview(fn($data) => $data?->id ?? '-')
                                    ->fields((new SeoResource())->getMorphFields())
                                    ->changeRender(function (?Seo $data, Template $field) {
                                        $fields = $field->preparedFields();
                                        $fields->fill($data?->toArray() ?? [], $data ?? new Seo());
                                        return Components::make($fields);
                                    })
                                    ->onAfterApply(function (Event $item, $value) {
                                        if ($value['title']) {
                                            $value['url'] = route('events.show', ['event' => $item->id]);
                                            $item->seo()->updateOrCreate([
                                                'id' => $value['id']
                                            ], $value);
                                        }
                                        return $item;
                                    }),
                            ]),

                        ]),
                    ])
                ])->columnSpan(8),

                Column::make([
                    Block::make([
                        Tabs::make([

                            Tab::make('Параметры', [

                                Enum::make(__('Status'), 'status')
                                    ->attach(EventStatusEnum::class)
                                    ->default(EventStatusEnum::DRAFT->name)
                                    ->placeholder('-')
                                    ->nullable()
                                    ->required(),

                                Enum::make(__('Age limit'), 'age_limit')
                                    ->attach(AgeLimitEnum::class)
                                    ->default(AgeLimitEnum::AGE_0->name)
                                    ->placeholder('-')
                                    ->nullable()
                                    ->required(),

                                Date::make(__('Event start'), 'event_start')->withTime()->required(),
                                Date::make(__('Guest start'), 'guest_start')->withTime()->required(),

                                BelongsTo::make(__('Place event'), 'place', fn($item) => "$item->name, $item->city")
                                    ->searchable()
                                    ->placeholder('-')
                                    ->nullable()
                                    ->required(),

                                Switcher::make(__('Recommendation'), 'recommendation')->default(false),

                                Image::make(__('Image'), 'image')->when(
                                    fn($field) => $field->isNowOnCreateForm(),
                                    fn($field) => $field->required()
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
                            ]),
                        ]),
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
            // StackFields::make('Время проведения')->fields([
            //     Date::make(__('Guest start'), 'guest_start')->format('d.m H.i')->sortable(),
            //     Date::make(__('Event start'), 'event_start')->format('d.m H.i')->sortable(),
            // ])->sortable(),
            Date::make(__('Event start'), 'event_start')->format('d.m H.i')->sortable(),
            Text::make(__('Title'), 'name', fn($item) => htmlspecialchars_decode($item->name))->sortable(),
            Enum::make(__('Status'), 'status')->attach(EventStatusEnum::class)->sortable(),
            BelongsTo::make(__('Place event'), 'place', fn($item) => "$item->name, $item->city")->sortable(),
            Enum::make(__('Age'), 'age_limit')->attach(AgeLimitEnum::class)->sortable(),
            Switcher::make('⭐️', 'recommendation')->sortable(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make(),
            Image::make(__('Image'), 'image'),
            Text::make(__('Title'), 'name', fn($item) => htmlspecialchars_decode($item->name)),
            Enum::make(__('Age limit'), 'age_limit')->attach(AgeLimitEnum::class),
            Enum::make(__('Status'), 'status')->attach(EventStatusEnum::class),
            Date::make(__('Event start'), 'event_start')->format('d.m H.i'),
            Date::make(__('Guest start'), 'guest_start')->format('d.m H.i'),
            BelongsTo::make(__('Place event'), 'place', fn($item) => "$item->name, $item->city"),
            Switcher::make(__('Recommendation'), 'recommendation'),
            TinyMce::make(__('Description'), 'description'),
        ];
    }

    public function filters(): array
    {
        return [
            Text::make(__('Title'), 'name'),
            Enum::make(__('Age limit'), 'age_limit')->attach(AgeLimitEnum::class)
                ->placeholder('-')
                ->nullable(),
            Enum::make(__('Status'), 'status')->attach(EventStatusEnum::class)
                ->placeholder('-')
                ->nullable(),
            Date::make(__('Date start'), 'event_start')->format('d.m H.i'),
            BelongsTo::make(__('Place event'), 'place', fn($item) => "$item->name, $item->city")
                ->nullable()
                ->placeholder('-'),
            Switcher::make(__('Recommendation'), 'recommendation')
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
