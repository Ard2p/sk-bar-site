<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\MuzlotoGame;

use Throwable;
use MoonShine\Fields\Text;
use MoonShine\Fields\Field;
use MoonShine\Pages\Crud\IndexPage;
use MoonShine\Components\MoonShineComponent;

class MuzlotoGameIndexPage extends IndexPage
{
    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Text::make('Название игры', 'name'),
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<MoonShineComponent>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
