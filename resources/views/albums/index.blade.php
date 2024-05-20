<x-app-layout>

    <div class="container mb-5">

        <x-caption>Альбомы</x-caption>

        @if ($vk_albums?->count())
            <x-albums :items="$vk_albums" />
        @endif

    </div>

</x-app-layout>
