@props(['item'])

<div class="d-flex h-100 flex-column shadow-sm rounded">

    <div class="ratio ratio-5x4">
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

    <div class="p-3 pt-2 h-100 d-flex flex-column">

        <a href="{{ route('events.show', $item->id) }}"
            class="fs-5 link-body-emphasis my-auto text-decoration-none">{!! $item->name !!}</a>

        <div>
            <span class="badge text-black bg-body-secondary">{{ $item->event_start->translatedFormat('d F') }}</span>
            <span class="badge text-white bg-info">{{ $item->age_limit }} +</span>
            {{-- <span class="badge text-white bg-primary">от 1 300 ₽</span> --}}
        </div>

        <div class="small mt-2">
            <div>{{ $item->place->name }}, {{ $item->place->city }}</div>
            <div>Вход: {{ $item->guest_start->format('H:i') }}</div>
            <div>Начало: {{ $item->event_start->format('H:i') }}</div>
        </div>


        <div class="d-flex justify-content-between mt-3">

            <a href="{{ route('events.show', $item->id) }}" @class([
                'btn btn-primary text-white',
                'w-100' => !$item->tickets_link,
            ])>Подробнее</a>

            @if ($item->tickets_link)
                <a href="{{ route('events.show', $item->id) }}?tikets" class="btn btn-primary text-white">
                    Купить Билеты
                </a>
            @endif

        </div>

    </div>

</div>
