<x-app-layout>

    <div class="container">

        <div class="row g-4 g-md-5 justify-content-center align-items-center">
            <div class="col-xl-7 me-auto">

                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">
                    Трибьют группы Rammstein
                </span>

                <h2 class="display-5 fw-semibold mb-5">RAMMproJect</h2>

            </div>
        </div>

        <div class="row">

            <div id="carouselMain" class="carousel slide carousel-fade" data-bs-ride="carousel">

                <div class="carousel-inner ratio ratio-21x9 rounded">

                    <div class="carousel-item active" data-bs-interval="10000">
                        <img src="{{ asset('storage/1.png') }}" class="d-block w-100">
                    </div>

                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="{{ asset('storage/1.png') }}" class="d-block w-100">
                    </div>
                </div>

                <button class="carousel-control-prev h-50 my-auto" type="button" data-bs-target="#carouselMain"
                    data-bs-slide="prev">
                    <i class="bi bi-chevron-compact-left text-primary fs-1"></i>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next h-50 my-auto" type="button" data-bs-target="#carouselMain"
                    data-bs-slide="next">
                    <i class="bi bi-chevron-compact-right text-primary fs-1"></i>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>

        <div class="row my-5">

            <div class="col-auto text-primary" style="text-shadow: 0px 0px 0.5em #161822;">
                <p>Русский драматический театр • 19 апреля, 18:30</p>
            </div>

            <div class="col-auto ms-auto">
                <span class="btn btn-primary">6 +</span>
                <span class="btn btn-primary">от 1 300 ₽</span>
            </div>

        </div>

        <div class="row my-5">

            <div class="col-12 1mx-auto">

                <div class="row mb-3">
                    <div class="col">
                        <div>Входной билет</div>
                    </div>
                    <div class="col-auto">
                        <span class="me-5">3 400 ₽</span>
                        <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div>Входной билет на 2 персоны</div>
                        <sub>Танцпол парный билет</sub>
                    </div>
                    <div class="col-auto">
                        <span class="me-5">3 400 ₽</span>
                        <span class="btn btn-primary"><i class="bi bi-dash-lg"></i></span>
                        <span class="btn btn-primary">0</span>
                        <span class="btn btn-primary"><i class="fw-bold bi bi-plus-lg"></i></span>
                    </div>
                </div>

            </div>

        </div>

        <div class="row mb-5">

            <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Фото</span>

            <div>

            </div>

        </div>

        <div class="row">

            <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Описание</span>

            <div>
                <p>Акустический концерт Константина Кулясова лидера группы «АнимациЯ». Душевный, разухабистый и мега
                    позитивный концерт! Приходите, будет интересно и весело! </p>

                <p>
                    «Я люблю свою Родину, вроде бы» — фраза из песни группы «АнимациЯ». Костя Кулясов, лидер группы,
                    и тот самый автор, у которого что ни песня, то крылатое выражение. Ты услышишь полтора десятка
                    ломовейших хитов и самые новые песни!
                </p>
            </div>

        </div>

        <div class="row mb-5">

            <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">Адрес</span>

            <div class="mb-3">
                <div>SK Bar</div>
                <div>просп. Горького, 5, корп. 2</div>
                <div>+7 (835) 237-49-11</div>
            </div>

            <div class="map">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Aed9e4d1da33fc1eb2311f8041fa5ae5ac98ac6b4b933ff25222f39642bbef391&amp;source=constructor"
                    width="100%" height="400" frameborder="0"></iframe>
            </div>

        </div>

    </div>


    <div class="container my-4 my-xxl-5 py-5">

        <div class="row g-4 g-md-5 justify-content-center align-items-center">
            <div class="col-xl-7 me-auto">

                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">
                    Лучшее только в Sk Bar
                </span>

                <h2 class="display-5 fw-semibold mb-5">Рекомендованные концерты</h2>

            </div>
        </div>

        <div class="col-12">
            <div class="row row-cols-lg-3 row-cols-md-3 row-cols-1 g-4">

                @for ($i = 0; $i < 3; $i++)
                    <div class="col">
                        <div class="d-flex flex-column position-relative">

                            <div class="ratio ratio-16x9">
                                <div>

                                    <img src="{{ asset('storage/1.png') }}" class="d-block w-100 rounded">

                                    <div class="position-absolute bottom-0 end-0 p-3"
                                        style="text-shadow: 0px 0px 0.5em #161822;">

                                        <span class="badge text-white text-bg-primary">6 +</span>
                                        <span class="badge text-white" style="background-color: #8f1de9;">от 1 300
                                            ₽</span>
                                    </div>

                                </div>
                            </div>

                            <div class="py-2">
                                <p class="fs-5 mb-2">
                                    <a href="/events/1"
                                        class="link-body-emphasis stretched-link text-decoration-none">RAMMproJect</a>
                                </p>

                                <div class="small">
                                    <div>Русский драматический театр</div>
                                    <div>19 апреля, 18:30</div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endfor

            </div>
        </div>

    </div>

    </div>

    <script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

    <script>
        var select_city = document.querySelector('#select_city')
        var select_box = document.querySelector('#select_box')

        dselect(select_city, {
            search: true
        })

        dselect(select_box, {
            search: true
        })
    </script>

</x-app-layout>
