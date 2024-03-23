<x-guest-layout>

    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-4">

                <div class="bg-body-tertiary rounded overflow-hidden p-4">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="{{ old('name') }}" required autofocus autocomplete="name">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input class="form-control" type="text" id="email" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input class="form-control" type="password" id="password" name="password" required
                                autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input class="form-control" type="password" id="password_confirmation"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">{{ $error }}</div>
                            @endforeach
                        @endif

                        <div class="mb-4 d-flex justify-content-between">
                            <a href="{{ route('login') }}">{{ __('Already registered?') }}</a>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">{{ __('Register') }}</button>

                    </form>


                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
