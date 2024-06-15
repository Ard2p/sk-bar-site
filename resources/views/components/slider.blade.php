@props(['items'])

<div class="carousel slide carousel-fade" data-bs-ride="carousel">

    <div class="carousel-inner ratio ratio-3x1 rounded">

        {{-- <div class="carousel-item active" data-bs-interval="10000">

                    <video class="d-block w-100 object-fit-cover h-100" autoplay loop muted preload="false"
                        pip="false" poster="{{ asset('storage/ыл.png') }}"
                        src="https://streaming.video.yandex.ru/get/film-trailers/m-67205-180cb95eae7-bf0ed2732c8a6c7b/480p.webm"></video>

                    <div class="position-absolute bottom-0 start-0 px-3 w-50"
                    style="text-shadow: 0px 0px 0.5em #161822;">
                        <h2>Три дня дождя</h2>
                        <p>Чебоксары-арена • 12 апреля, 20:00</p>
                    </div>

                    <div class="position-absolute bottom-0 end-0 p-3">
                        <span class="btn btn-primary">6 +</span>
                        <a href="/" class="btn btn-primary">от 1 300 ₽</a>
                    </div>
                </div> --}}

        @foreach ($items as $slide)
            <div @class(['carousel-item', 'active' => $loop->first])>

                @if ($slide->link)
                    <a href="{{ $slide->link }}">
                @endif

                <img src="{{ asset('storage/' . $slide->image) }}" class="d-block w-100">

                @if ($slide->link)
                    </a>
                @endif

            </div>
        @endforeach

    </div>

    @if ($items->count() > 1)
        <button class="carousel-control-prev h-50 my-auto" type="button" data-bs-target="#carouselMain"
            data-bs-slide="prev">
            <i class="bi bi-chevron-compact-left text-primary fs-1"></i>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next h-50 my-auto" type="button" data-bs-target="#carouselMain"
            data-bs-slide="next">
            <i class="bi bi-chevron-compact-right text-primary fs-1"></i>
            <span class="visually-hidden">Next</span>
        </button>
    @endif

</div>
