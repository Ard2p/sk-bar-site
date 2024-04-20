<x-app-layout>

    @if ($slider->count())
        <div class="container mb-5">
            <x-slider :items="$slider" />
        </div>
    @endif

    @if (false)
        <div class="container mb-5">
            <x-menu-swiper />
        </div>
    @endif

    @if ($coming_events->count())
        <div class="container mb-5">

            <x-caption sub="Лучшее только в Sk Bar">События в ближайшие дни</x-caption>

            <x-events.list :items="$coming_events" />

        </div>
    @endif

    @if ($recommended_events->count())
        <div class="container mb-5">

            <x-caption sub="Лучшее только в Sk Bar">Рекомендованные концерты</x-caption>

            <x-events.list :items="$recommended_events" />

        </div>
    @endif

    @if ($vk_albums->count())
        <div class="container mb-5">

            <x-caption sub="Лучшее только в Sk Bar">Фото</x-caption>

            <x-gallery :items="$vk_albums" />

        </div>
    @endif

</x-app-layout>
