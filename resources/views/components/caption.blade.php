@props(['sub'])

<div class="row g-4 g-md-5 justify-content-center align-items-center">
    <div class="col-xl-7 me-auto">

        @if (isset($sub))
            <span class="text-primary mb-1 d-block text-uppercase fw-semibold ls-xl">{{ $sub }}</span>
        @endif

        <h2 class="display-5 fw-semibold mb-2">{{ $slot }}</h2>

    </div>
</div>
