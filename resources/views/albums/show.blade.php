<x-app-layout>

    <div class="container mb-5">

        <x-caption>{{ $album['title'] }}</x-caption>

        @if ($vk_photos?->count())
            <x-gallery :items="$vk_photos" />
        @endif

    </div>

</x-app-layout>
