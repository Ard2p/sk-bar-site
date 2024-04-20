@props(['items'])

<div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 g-4">
    @foreach ($items as $key => $item)
        <div @class([
            'col',
            'd-md-none d-lg-block' => $loop->last && ($key + 1) % 2 != 0,
            'd-lg-none d-xxl-block' => $key + 1 > 3,
        ])>
            <x-events.card :item="$item" />
        </div>
    @endforeach
</div>
