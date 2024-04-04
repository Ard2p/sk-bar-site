<?php

namespace App\MoonShine\Pages;

use MoonShine\Fields\ID;
use MoonShine\Pages\Page;
use MoonShine\Fields\Text;
use MoonShine\Fields\Image;
use MoonShine\MoonShineAuth;
use MoonShine\Decorations\Tab;
use MoonShine\Fields\Password;
use MoonShine\Decorations\Tabs;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Heading;
use MoonShine\TypeCasts\ModelCast;
use MoonShine\Fields\PasswordRepeat;
use MoonShine\Components\FormBuilder;
use MoonShine\Components\FlexibleRender;
use MoonShine\Http\Controllers\ProfileController;

class ProfilePage extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title(),
        ];
    }

    public function title(): string
    {
        return __('moonshine::ui.profile');
    }

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()
                    ->sortable()
                    ->showOnExport(),

                Text::make(trans('moonshine::ui.resource.name'), 'name')
                    ->setValue(auth()->user()
                        ->{config('moonshine.auth.fields.name', 'name')})
                    ->required(),

                Text::make(trans('moonshine::ui.login.username'), 'username')
                    ->setValue(auth()->user()
                        ->{config('moonshine.auth.fields.username', 'email')})
                    ->required(),

                Heading::make(__('moonshine::ui.resource.change_password')),

                Password::make(trans('moonshine::ui.resource.password'), 'password')
                    ->customAttributes(['autocomplete' => 'new-password'])
                    ->eye(),

                PasswordRepeat::make(trans('moonshine::ui.resource.repeat_password'), 'password_repeat')
                    ->customAttributes(['autocomplete' => 'confirm-password'])
                    ->eye(),
            ]),
        ];
    }

    public function components(): array
    {
        return [
            FormBuilder::make(action([ProfileController::class, 'store']))
                ->async()
                ->customAttributes([
                    'enctype' => 'multipart/form-data',
                ])
                ->fields($this->fields())
                ->cast(ModelCast::make(MoonShineAuth::model()::class))
                ->submit(__('moonshine::ui.save'), [
                    'class' => 'btn-lg btn-primary',
                ]),

            FlexibleRender::make(
                view('moonshine::ui.social-auth', [
                    'title' => trans('moonshine::ui.resource.link_socialite'),
                    'attached' => true,
                ])
            ),
        ];
    }
}
