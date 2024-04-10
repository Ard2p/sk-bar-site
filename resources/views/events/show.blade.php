<x-app-layout>

    <div class="container">

        <x-caption :sub="$event->caption">{{ $event->name }}</x-caption>

        {{-- <div class="row">

            <div id="carouselMain" class="carousel slide carousel-fade" data-bs-ride="carousel">

                <div class="carousel-inner ratio ratio-21x9 rounded">

                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="{{ asset('storage/' . $event->banner) }}" class="d-block w-100">
                    </div>

                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="{{ asset('storage/' . $event->banner) }}" class="d-block w-100">
                    </div>
                </div>

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
            </div>

        </div> --}}

        <div class="row mb-5">

            <div class="col-auto text-primary">
                <p>{{ $event->place->name }}, {{ $event->place->city }}, {{ $event->place->adress }}</p>
                <span
                    class="badge text-black bg-body-secondary">{{ $event->event_start->translatedFormat('d F') }}</span>
                <span class="badge text-white bg-info">{{ $event->age_limit }} +</span>
                <span class="badge text-white bg-primary">от 1 300 ₽</span>
            </div>

        </div>

        <div class="row mb-5">

            <div class="col-lg-8">

                <div class="row mb-5">

                    <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Фото</span>

                    <div>

                    </div>

                </div>

                <div class="row">

                    <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Описание</span>

                    <div>{!! $event->description !!}</div>

                </div>

            </div>

            <div class="col-lg-4">

                <div class="row mb-3">
                    <img src="{{ asset('storage/' . $event->image) }}" class="object-fit-cover">
                </div>

                <div class="row mb-3">

                    <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Билеты</span>

                    <div class="col">
                        <div>Входной билет</div>
                    </div>
                    <div class="col-auto">
                        <span class="me-5">3 400 ₽</span>
                        <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div>Входной билет на 2 персоны</div>
                        <sub>Танцпол парный билет</sub>
                    </div>
                    <div class="col-auto">
                        <span class="me-5">3 400 ₽</span>
                        <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span>
                    </div>
                </div>

                <div class="row ">
                    <button class="btn btn-primary">Купить</button>
                </div>

            </div>

        </div>

        <div class="row mb-5">

            <div class="col-12 col-md-4 mb-3">
                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Адрес</span>

                <div>{{ $event->place->name }}</div>
                <div>{{ $event->place->adress }}</div>
                <div>+7 (835) 237-49-11</div>
            </div>

            <div class="col-12 col-md-8 map">
                <iframe class="rounded"
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Aed9e4d1da33fc1eb2311f8041fa5ae5ac98ac6b4b933ff25222f39642bbef391&amp;source=constructor&amp;scroll=false"
                    width="100%" height="400" frameborder="0"></iframe>
            </div>

        </div>

    </div>


    <div class="container my-4 my-xxl-5 py-5">

        <x-caption sub="Лучшее только в Sk Bar">Рекомендованные концерты</x-caption>

        @include('events.parts.list', ['col_lg' => 4, 'col_md' => 2, 'items' => $recommended_events])

    </div>

    </div>

    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <script>
        var select_city = document.querySelector('#select_city')
        var select_box = document.querySelector('#select_box')

        dselect(select_city, {
            search: true
        })

        dselect(select_box, {
            search: true
        })
    </script>

</x-app-layout>
