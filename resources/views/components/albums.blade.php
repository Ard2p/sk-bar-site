@props(['items'])

<div class="row row-cols-lg-6 row-cols-3 g-1 gallery">
    @foreach ($items as $item)
        <div class="col">
            <div class="ratio ratio-1x1">

                <a href="/albums/{{ $item['id'] }}">

                    <img src="{{ $item['photo']['small']['url'] }}" class="d-block object-fit-cover w-100 h-100">

                    <div>
                        <div class="position-absolute bottom-0 p-2 d-grid" style="background: rgb(0 0 0 / 50%);">
                            <div class="text-white text-truncate" title="{{ $item['title'] }}"
                                style="font-size: 12px;font-weight: bold;">{{ $item['title'] }}</div>
                            {{-- <div class="text-white">{{ $item['size'] }}</div> --}}
                        </div>
                    </div>

                </a>
            </div>
        </div>
    @endforeach
</div>
