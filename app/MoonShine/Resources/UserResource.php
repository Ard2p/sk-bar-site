<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use Illuminate\Validation\Rule;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Date;
use MoonShine\Fields\Email;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Password;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Fields\Text;
use MoonShine\FormComponents\ChangeLogFormComponent;
use MoonShine\Resources\ModelResource;
use Sweet1s\MoonshineRBAC\Traits\WithRoleFormComponent;
use Sweet1s\MoonshineRBAC\Traits\WithRolePermissions;

class UserResource extends ModelResource
{
    use WithRolePermissions;
    use WithRoleFormComponent;

    public string $model = User::class;
    public string $titleField = 'name';

    public function title(): string
    {
        return trans('Users');
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
            Grid::make([
                Column::make([
                    Block::make(
                        trans('moonshine::ui.resource.main_information'),
                        [
                            ID::make()
                                ->sortable()
                                ->useOnImport()
                                ->showOnExport(),

                            Text::make(trans('moonshine::ui.resource.name'), 'name')
                                ->required()
                                ->useOnImport()
                                ->showOnExport(),

                            Date::make(trans('moonshine::ui.resource.created_at'), 'created_at')
                                ->format('d.m.Y')
                                ->default(now()->toDateTimeString())
                                ->sortable()
                                ->hideOnForm()
                                ->showOnExport(),

                            Email::make(trans('moonshine::ui.resource.email'), 'email')
                                ->sortable()
                                ->showOnExport()
                                ->required(),
                        ]
                    ),
                ])->columnSpan(6),

                Column::make([
                    Block::make(
                        trans('moonshine::ui.resource.change_password'),
                        [
                            Password::make(trans('moonshine::ui.resource.password'), 'password')
                                ->customAttributes(
                                    ['autocomplete' => 'new-password']
                                )
                                ->hideOnIndex()
                                ->hideOnExport()
                                ->hideOnDetail()
                                ->eye(),

                            PasswordRepeat::make(trans('moonshine::ui.resource.repeat_password'), 'password_repeat')
                                ->customAttributes(
                                    ['autocomplete' => 'confirm-password']
                                )
                                ->hideOnIndex()
                                ->hideOnExport()
                                ->hideOnDetail()
                                ->eye(),
                        ]
                    ),
                ])->columnSpan(6),
            ]),
        ];
    }

    public function rules($item): array
    {
        return [
            'name' => 'required',
            'email' => [
                'sometimes',
                'bail',
                'required',
                'email',
                Rule::unique('users')->ignoreModel($item),
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|min:6|required_with:password_repeat|same:password_repeat'
                : 'required|min:6|required_with:password_repeat|same:password_repeat',
        ];
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    public function filters(): array
    {
        return [
            Text::make(trans('moonshine::ui.resource.name'), 'name'),
            Date::make(trans('moonshine::ui.resource.created_at'), 'created_at'),
        ];
    }
}
