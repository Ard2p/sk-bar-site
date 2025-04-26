<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Domain;
use MoonShine\Fields\ID;

use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Decorations\Block;
use MoonShine\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Domain>
 */
class DomainResource extends ModelResource
{
    protected string $model = Domain::class;

    protected string $title = 'Домены';

    protected bool $isAsync = true;

    protected int $itemsPerPage = 20;

    public function getActiveActions(): array
    {
        return ['create', 'update', 'delete', 'massDelete'];
    }

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

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Домен', 'domain')->required(),
            ]),
        ];
    }

    /**
     * @param Domain $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
