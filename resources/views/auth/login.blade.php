<x-guest-layout>

    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-4">

                <div class="bg-body-tertiary rounded overflow-hidden p-4">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input class="form-control" type="text" id="email" name="email"
                                value="{{ old('email') }}" required autofocus autocomplete="email">
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input class="form-control" type="password" id="password" name="password" required
                                autocomplete="current-password">
                        </div>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">{{ $error }}</div>
                            @endforeach
                        @endif

                        <div class="mb-4 d-flex justify-content-between">
                            <div class="checkbox">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            @endif

                        </div>

                        <button class="btn btn-primary w-100" type="submit">{{ __('Log in') }}</button>

                    </form>

                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
