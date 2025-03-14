<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-4 col-lg-6 col-12">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>

            <input type="password" id="update_password_current_password" name="current_password" class="form-control"
                autocomplete="current-password">

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-4 col-lg-6 col-12">
            <label for="update_password_password" class="form-label">{{ __('Password') }}</label>

            <input type="password" id="update_password_password" name="password" class="form-control"
                autocomplete="new-password">

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mb-4 col-lg-6 col-12">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>

            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                class="form-control" autocomplete="new-password">

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

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
