<?php

declare(strict_types=1);

namespace App\Providers;

use MoonShine\Menu\MenuItem;
use MoonShine\Menu\MenuGroup;
use App\MoonShine\Resources\EventsResource;
use MoonShine\Providers\MoonShineApplicationServiceProvider;

class MoonShineServiceProvider extends MoonShineApplicationServiceProvider
{
    protected function resources(): array
    {
        return [];
    }

    protected function pages(): array
    {
        return [];
    }

    protected function menu(): array
    {
        return [
            // MenuGroup::make(static fn() => __('moonshine::ui.resource.system'), [

            //    MenuItem::make(__('Events'), new EventsResource())

            // ]),

            MenuItem::make(__('Events'), new EventsResource())
        ];
    }

    /**
     * @return array{css: string, colors: array, darkColors: array}
     */
    protected function theme(): array
    {
        return [];
    }
}
