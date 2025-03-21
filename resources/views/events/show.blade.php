<x-app-layout>
    <div class="container mb-5">

        <x-caption :sub="$event->caption">{!! $event->name !!}</x-caption>

        <div class="row mb-5">

            <div class="col-auto text-primary">
                <p>{{ $event->place->name }}, {{ $event->place->city }}, {{ $event->place->adress }}</p>
                <span class="badge text-black bg-body-secondary">
                    {{ Str::ucfirst($event->event_start->minDayName) }}
                    {{ $event->event_start->translatedFormat('d F') }}
                </span>
                <span class="badge text-white bg-info">{{ $event->age_limit }} +</span>
                {{-- <span class="badge text-white bg-primary">от 1 300 ₽</span> --}}
            </div>

        </div>

        <div class="row mb-5">

            <div class="col-lg-8 order-lg-1 order-2">

                {{-- <div class="row mb-5">

                    <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Фото</span>

                    <div>

                    </div>

                </div> --}}

                <div class="row">

                    <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Описание</span>

                    <div>{!! $event->description !!}</div>

                </div>

            </div>

            <div class="col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0">

                <div class="row mb-3">
                    <img src="{{ asset('storage/' . $event->image) }}" class="object-fit-cover">
                </div>

                <div class="row tickets" id="buyTiketsHeader">

                    {{-- <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl"
                        id="buyTiketsHeader">Билеты</span> --}}

                    @if ($event->tickets_link)
                        <div class="col">
                            <button class="btn btn-primary text-white w-100" data-bs-toggle="modal"
                                data-bs-target="#buyTikets">Купить билеты</button>
                        </div>
                    @endif

                    @if ($event->on_reserve)
                        <div class="col">
                            <button class="btn btn-primary text-white w-100" data-bs-toggle="modal"
                                data-bs-target="#reservTable">Бронь стола</button>
                        </div>
                    @endif

                    @if ($event->tickets_link)
                        <div class="modal" id="buyTikets" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="ratio ratio-16x9">

                                        @switch($event->tickets_type)
                                            @case('ticketscloud')
                                                {!! html_entity_decode($event->tickets_link) !!}
                                            @break

                                            @default
                                                {{-- Qtickets --}}
                                                <iframe class="w-100" src="{{ $event->tickets_link }}"></iframe>
                                        @endswitch

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($event->on_reserve)
                        <div class="modal" id="reservTable" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content pb-3">

                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <x-events.reserv :event="$event" />

                                </div>
                            </div>
                        </div>
                    @endif

                    @if (false)
                        <div class="row mb-3">

                            <div class="col">
                                <div>Входной билет</div>
                            </div>
                            <div class="col-auto">
                                <span>3 400 ₽</span>
                                {{-- <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span> --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div>Входной билет на 2 персоны</div>
                                <sub>Танцпол парный билет</sub>
                            </div>
                            <div class="col-auto">
                                <span>3 400 ₽</span>
                                {{-- <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span> --}}
                            </div>
                        </div>

                        <div class="col">
                            <button class="btn btn-primary w-100">Купить</button>
                        </div>
                    @endif

                </div>

            </div>

        </div>

        <div class="row mb-5">

            <div class="col-12 col-md-4 mb-3">
                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Адрес</span>

                <div>{{ $event->place->name }}</div>
                <div>{{ $event->place->adress }}</div>
                @if ($event->place->content)
                    <div>{!! $event->place->content !!}</div>
                @endif
            </div>

            @if ($event->place->map)
                <div class="col-12 col-md-8 map">
                    <iframe class="rounded" src="{{ $event->place->map }}" width="100%" height="400"
                        frameborder="0"></iframe>
                </div>
            @endif

        </div>

    </div>

    @if ($recommended_events->count())
        <div class="container mb-5">

            <x-caption sub="Лучшее только в Sk Bar">Рекомендованные концерты</x-caption>

            <x-events.list :items="$recommended_events" />

        </div>
    @endif

    @push('metrics')

        @if ($event->metrics)
            {!! $event->metrics !!}
        @endif

        @switch($event->tickets_type)
            @case('ticketscloud')
                <script src="https://ticketscloud.com/static/scripts/widget/tcwidget.js"></script>
            @break
        @endswitch

        <script>
            window.addEventListener('load', function() {
                const url = new URL(document.location)
                const searchParams = url.searchParams;

                let modalId = null

                // switch (url.hash) {
                //     case 'tikets':
                //         modalId = 'buyTikets'
                //         break;
                //     case 'reserve':
                //         modalId = 'reservTable'
                //         break;
                // }

                if (searchParams.has('tikets')) {
                    searchParams.delete('tikets');
                    modalId = 'buyTikets';
                }

                if (searchParams.has('reserve')) {
                    searchParams.delete('reserve');
                    modalId = 'reservTable';
                }

                if (modalId) {
                    // url.hash = ''
                    window.history.pushState({}, '', url.toString());
                    const elementModal = document.getElementById(modalId)
                    if (elementModal && elementModal.classList.contains('modal')) {
                        const myModal = new window.bootstrap.Modal('#' + modalId)
                        myModal.show()
                    } else {
                        const element = document.getElementById('buyTiketsHeader')
                        element.scrollIntoView()
                    }
                }
            })
        </script>
    @endpush

</x-app-layout>
