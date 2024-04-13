<div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 g-4">

    {{-- @dd(collect($items)) --}}
    @foreach ($items as $key => $item)
        <div @class([
            'col',
            'd-md-none d-lg-block' => $loop->last && ($key + 1) % 2 != 0,
            'd-lg-none d-xxl-block' => $key + 1 > 3,
        ])>
            @include('events.parts.card', ['item' => $item])
        </div>
    @endforeach

</div>
