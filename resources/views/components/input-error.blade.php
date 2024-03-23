@props(['messages'])

@if ($messages)
    <ul>
        @foreach ((array) $messages as $message)
            <li {{ $attributes->merge(['class' => 'alert alert-danger']) }} role="alert">{{ $message }}</li>
        @endforeach
    </ul>
@endif
