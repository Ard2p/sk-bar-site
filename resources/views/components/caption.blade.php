@props(['sub'])

@if (isset($sub))
    <span class="text-primary mb-1 d-block text-uppercase fw-semibold ls-xl">{{ $sub }}</span>
@endif

<h2 class="display-5 fw-semibold mb-2">{{ $slot }}</h2>
