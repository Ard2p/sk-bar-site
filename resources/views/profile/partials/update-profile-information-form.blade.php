<section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" x-data>
        @csrf
        @method('patch')


        <div class="mb-4 col-lg-6 col-12">
            <label for="name" class="form-label">Имя</label>

            <input type="text" id="name" name="name" class="form-control" placeholder="Как вас зовут?"
                required autofocus autocomplete="name" maxlength="100" value="{{ old('name', $user->name) }}">

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-4 col-lg-6 col-12">
            <label for="phone" class="form-label">Номер телефона</label>

            <input type="text" id="phone" name="phone" class="form-control" placeholder="Ваш номер телефона?"
                required autocomplete="phone" x-mask="+7 (999) 999-99-99" min="18"
                value="{{ old('phone', $user->phone) ?? '+7' }}">

            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- <div class="mb-4">
            <label for="name" class="form-label">Email</label>

            <input type="email" id="email" name="email" class="form-control" required autocomplete="username"
                value="{{ old('name', $user->email) }}">

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div> --}}

        <div class="flex items-center gap-4">
            <button class="btn btn-primary text-white">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                {{-- <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="badge bg-success">{{ __('Saved.') }}</span> --}}
                <span x-data x-init="saved()"></span>
            @endif
        </div>
    </form>
</section>

<script>
    function saved() {
        new window.bs5.Toast({
            body: "{{ __('Saved.') }}",
            delay: 5000,
            className: 'border-0 bg-success text-white',
        }).show()
    }
</script>
