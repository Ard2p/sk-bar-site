<?php

declare(strict_types=1);

namespace App\Providers;

use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use App\MoonShine\Resources\SeoResource;
use App\MoonShine\Resources\PageResource;
use App\MoonShine\Resources\RoleResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\PlaceResource;
use App\MoonShine\Resources\EventsResource;
use App\MoonShine\Resources\SettingResource;
use Sweet1s\MoonshineRBAC\Components\MenuRBAC;
use MoonShine\Providers\MoonShineApplicationServiceProvider;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [
            // new PageResource()
        ];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return MenuRBAC::menu(

            MenuItem::make(__('Home site'), '/', 'heroicons.outline.globe-alt'),

            MenuItem::make(__('Dashboard'), '/admin', 'heroicons.outline.presentation-chart-line'),

            MenuItem::make(__('Events'), new EventsResource(), 'heroicons.outline.star'),

            MenuItem::make(__('Pages'), new PageResource(), 'heroicons.outline.document-text'),

            // MenuItem::make(__('Menu'), new PageResource(), 'heroicons.outline.bars-3'),

            MenuItem::make(__('Users'), new UserResource(), 'heroicons.outline.user-group'),

            MenuItem::make(__('Permissions'), new RoleResource(), 'heroicons.outline.shield-exclamation'),

            MenuItem::make(__('Seo'), new SeoResource(), 'heroicons.outline.magnifying-glass'),

            MenuItem::make(__('Places event'), new PlaceResource(), 'heroicons.outline.map-pin'),

            // MenuItem::make(__('Home'), new PageResource(), 'heroicons.outline.home'),

            // MenuItem::make(__('Settings'), new SettingResource()),

            // MenuGroup::make(__('System'), [], 'heroicons.outline.user-group'),
        );
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }

    public function boot(): void
    {
        parent::boot();
        // moonshineAssets()->add(['/vendor/moonshine/assets/minimalistic.css']);
        // moonshineColors()
        //     ->primary('#1E96FC')
        //     ->secondary('#1D8A99')
        //     ->body('255, 255, 255')
        //     ->dark('30, 31, 67', 'DEFAULT')
        //     ->dark('249, 250, 251', 50)
        //     ->dark('243, 244, 246', 100)
        //     ->dark('229, 231, 235', 200)
        //     ->dark('209, 213, 219', 300)
        //     ->dark('156, 163, 175', 400)
        //     ->dark('107, 114, 128', 500)
        //     ->dark('75, 85, 99', 600)
        //     ->dark('55, 65, 81', 700)
        //     ->dark('31, 41, 55', 800)
        //     ->dark('17, 24, 39', 900)
        //     ->successBg('209, 255, 209')
        //     ->successText('15, 99, 15')
        //     ->warningBg('255, 246, 207')
        //     ->warningText('92, 77, 6')
        //     ->errorBg('255, 224, 224')
        //     ->errorText('81, 20, 20')
        //     ->infoBg('196, 224, 255')
        //     ->infoText('34, 65, 124');

        // moonshineColors()
        //     ->body('27, 37, 59', dark: true)
        //     ->dark('83, 103, 132', 50, dark: true)
        //     ->dark('74, 90, 12', 100, dark: true)
        //     ->dark('65, 81, 114', 200, dark: true)
        //     ->dark('53, 69, 103', 300, dark: true)
        //     ->dark('48, 61, 93', 400, dark: true)
        //     ->dark('41, 53, 82', 500, dark: true)
        //     ->dark('40, 51, 78', 600, dark: true)
        //     ->dark('39, 45, 69', 700, dark: true)
        //     ->dark('27, 37, 59', 800, dark: true)
        //     ->dark('15, 23, 42', 900, dark: true)
        //     ->successBg('17, 157, 17', dark: true)
        //     ->successText('178, 255, 178', dark: true)
        //     ->warningBg('225, 169, 0', dark: true)
        //     ->warningText('255, 255, 199', dark: true)
        //     ->errorBg('190, 10, 10', dark: true)
        //     ->errorText('255, 197, 197', dark: true)
        //     ->infoBg('38, 93, 205', dark: true)
        //     ->infoText('179, 220, 255', dark: true);
    }
}
