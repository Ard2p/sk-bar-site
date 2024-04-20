<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Validation\Rule;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;
use MoonShine\ActionButtons\ActionButton;
use MoonShine\Decorations\Block;
use Leeto\Seo\Rules\UrlRule;
use App\Models\Seo;
use MoonShine\Decorations\Column;

// use App\Models\Place;

class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    protected string $title = 'Seo';

    protected string $column = 'title';

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
            Block::make([
                ID::make()
                    ->showOnExport()
                    ->useOnImport()
                    ->sortable(),

                Text::make('Url')
                    ->required()
                    ->showOnExport()
                    ->useOnImport(),

                Text::make('Title')
                    ->required()
                    ->showOnExport()
                    ->useOnImport(),

                Text::make('Description')
                    ->showOnExport()
                    ->useOnImport(),

                Text::make('Keywords')
                    ->showOnExport()
                    ->useOnImport(),

                TinyMce::make('Text')
                    ->showOnExport()
                    ->useOnImport()
            ])
        ];
    }

    public function getMorphFields(): array
    {
        return [
            Column::make([
                ID::make(),
                Text::make('Url'),
                Text::make('Title'),
                Text::make('Description'),
                Text::make('Keywords'),
                TinyMce::make('Text')
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'title' => ['required', 'string', 'min:1'],
            'url' => [
                'required',
                'string',
                new UrlRule,
                Rule::unique('seo')->ignoreModel($item)
            ]
        ];
    }

    public function search(): array
    {
        return ['id', 'url'];
    }

    public function filters(): array
    {
        return [
            Text::make('Url')->required(),
        ];
    }

    public function indexButtons(): array
    {
        return [
            ActionButton::make('Go to', static fn (Seo $item) => $item->url)
                ->icon('heroicons.outline.paper-clip')
        ];
    }
}
