<div class="d-flex flex-column position-relative shadow-sm rounded">

    <div class="ratio ratio-13x10">
        <div>

            <a href="{{ route('events.show', $item->id) }}">
                <img src="{{ asset('storage/' . $item->image) }}" class="d-block w-100 h-100">
            </a>

            {{-- <div class="position-absolute top-0 start-0 p-3">
                <div class="badge rounded-1 text-black bg-white">
                    <span class="fs-5">19</span><br>апр
                </div>
            </div>

            <div class="position-absolute top-0 end-0 p-3" style="text-shadow: 0px 0px 0.5em #161822;">
                <span class="badge text-white bg-info">6 +</span>
            </div>

            <div class="position-absolute bottom-0 end-0 p-3" style="text-shadow: 0px 0px 0.5em #161822;">
                <span class="badge text-white bg-primary">от 1 300 ₽</span>
            </div> --}}

        </div>
    </div>

    <div class="p-3 pt-2">

        <a href="{{ route('events.show', $item->id) }}"
            class="fs-5 link-body-emphasis stretched-link-off text-decoration-none">{{ $item->name }}</a>

        <div>
            <span class="badge text-black bg-body-secondary">{{ $item->event_start->translatedFormat('d F') }}</span>
            <span class="badge text-white bg-info">{{ $item->age_limit }} +</span>
            <span class="badge text-white bg-primary">от 1 300 ₽</span>
        </div>

        <div class="small mt-2">
            <div>{{ $item->place->name }}, {{ $item->place->city }}</div>
            <div>Запуск гостей: {{ $item->guest_start->format('H:i') }}</div>
            <div>Начало: {{ $item->event_start->format('H:i') }}</div>
        </div>

        <div class="mt-3">
            <a href="{{ route('events.show', $item->id) }}" class="col-auto btn btn-primary text-white">Подробнее</a>
            <a href="{{ route('events.show', $item->id) }}" class="col-auto btn btn-primary text-white">
                Купить Билеты
            </a>
        </div>

    </div>

</div>
