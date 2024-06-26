<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;


use App\Models\Role;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use Sweet1s\MoonshineRBAC\Traits\WithPermissionsFormComponent;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

class RoleResource extends ModelResource
{
    use WithRolePermissions;
    use WithPermissionsFormComponent;

    public string $model = Role::class;

    public string $titleField = 'name';

    public function title(): string
    {
        return trans('Permissions');
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

    public function fields(): array
    {
        return [
            Block::make('', [
                Text::make(trans('moonshine::ui.resource.role_name'), 'name')
                    ->required()->showOnExport(),
            ])
        ];
    }

    public function rules($item): array
    {
        return [
            'name' => 'required|min:5',
        ];
    }

    public function search(): array
    {
        return ['name'];
    }

    // public function filters(): array
    // {
    //     return [
    //         Text::make(trans('moonshine::ui.resource.role_name'), 'name'),
    //     ];
    // }
}
