<nav class="container mt-md-4 mb-3">
    <div class="my-2 my-lg-4">

        <header>

            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="/">
                    <img height="50px" src="{{ asset('storage/skbar.png') }}">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @php
                            //  :active="request()->routeIs('dashboard')"
                        @endphp

                        {{-- <li>
                            <a href="{{ route('events') }}" class="nav-link px-3 link-body-emphasis">{{ __('Events') }}</a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" class="nav-link active">{{ __('Events') }}</a>
                        </li>

                        <li class="nav-item">
                            <a href="/" class="nav-link active">Меню</a>
                        </li>

                        <li class="nav-item">
                            <a href="/" class="nav-link active">Бронь столов</a>
                        </li>

                    </ul>

                    @auth
                        <div class="nav dropdown text-end">
                            <a href="#" class="avatar avatar-sm position-relative dropdown-toggle"
                                id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                <div>{{ Auth::user()->name }}</div>
                                <img src="https://avatars.githubusercontent.com/u/5220449?v=4"
                                    class="avatar-img rounded-circle border border-tertiary-subtle">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUserMenu">
                                <li><a class="dropdown-item" href="route('profile.edit')">{{ __('Profile') }}</a></li>
                                <li><a class="dropdown-item" href="route('dashboard')">{{ __('Dashboard') }}</a></li>

                                <div class="dropdown-divider"></div>

                                <form class="px-3" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="btn btn-secondary" type="submit">{{ __('Log Out') }}</button>
                                </form>
                            </ul>
                        </div>
                    @else
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Log in') }}</a>
                            {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Register') }}</a>
                            @endif --}}
                        </div>
                    @endauth

                </div>

            </nav>

        </header>

    </div>
</nav>
