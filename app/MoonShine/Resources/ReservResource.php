<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Reserv;

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
class ReservResource extends ModelResource
{
    use WithRolePermissions;

    protected string $model = Reserv::class;

    protected string $title = 'Бронирование';

    public function rules(Model $item): array
    {
        return [];
    }
}
