<div class="row row-cols-lg-{{ $col_lg }} row-cols-md-{{ $col_md }} row-cols-1 g-4">

    @foreach ($items as $item)
        <div class="col">
            @include('events.parts.card', ['item' => $item])
        </div>
    @endforeach

</div>
