<div class="col-12">
    <div class="row row-cols-lg-{{ $col_lg }} row-cols-md-{{ $col_md }} row-cols-1 g-4">

        @for ($i = 0; $i < $count; $i++)
            <div class="col">
                @include('events.parts.card')
            </div>
        @endfor

    </div>
</div>
