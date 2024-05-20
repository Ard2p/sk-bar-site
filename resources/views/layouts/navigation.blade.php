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

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a href="{{ route('events.index') }}" @class(['nav-link', 'active' => request()->routeIs('events.index')])>{{ __('Events') }}</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('rkmenu') }}" @class(['nav-link', 'active' => request()->routeIs('rkmenu')])>Меню</a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('reservation.index') }}" @class([
                                'nav-link',
                                'active' => request()->routeIs('reservation.index'),
                            ])>Бронь столов</a>
                        </li> --}}

                    </ul>

                    <div class="text-muted small d-none d-lg-block">
                        <div><span class="text-primary fw-bold">SK Bar,</span> Чебоксары, Карла Маркса 47</div>
                        <div class="text-primary fw-bold">+7 835 236 26 26</div>
                        <div>чт-вс: <span class="text-primary fw-bold">17:00 - 02:00</span></div>
                    </div>

                    @if (false)
                        <div class="col-12 col-lg-2 d-flex justify-content-lg-end">
                            @auth
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle text-primary text-decoration-none"
                                        id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <ul class="dropdown-menu bg-body-secondary" aria-labelledby="dropdownUserMenu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('home') }}">{{ __('Home') }}</a></li>

                                        <div class="dropdown-divider"></div>

                                        <form class="px-3" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="btn btn-primary" type="submit">{{ __('Log Out') }}</button>
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
                    @endif

                </div>

            </nav>

        </header>

    </div>
</nav>
