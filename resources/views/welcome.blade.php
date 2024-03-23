<x-app-layout>

    <div class="container">
        <div class="row">

            <div id="carouselExampleDark" class="carousel slide carousel-fade" data-bs-ride="carousel">

                <div class="carousel-inner ratio ratio-21x9 rounded">

                    <div class="carousel-item active" data-bs-interval="10000">

                        <video class="d-block w-100" autoplay loop muted preload="false" pip="false" poster="cake.jpg"
                            src="https://streaming.video.yandex.ru/get/film-trailers/m-67205-180cb95eae7-bf0ed2732c8a6c7b/480p.webm"></video>

                        <div class="carousel-caption">
                            <h2>Три дня дождя</h2>
                            <p>Чебоксары-арена • 12 апреля, 20:00</p>
                        </div>

                        <div class="carousel-tag">
                            <span class="btn btn-primary">6 +</span>
                            <a href="/" class="btn btn-primary">от 1 300 ₽</a>
                        </div>
                    </div>

                    <div class="carousel-item" data-bs-interval="10000">
                        <img src="{{ asset('storage/1.png') }}" class="d-block w-100">

                        <div class="carousel-caption">
                            <h2>RAMMproJect</h2>
                            <p>Русский драматический театр • 19 апреля, 18:30</p>
                        </div>

                        <div class="carousel-tag">
                            <span class="btn btn-primary">18 +</span>
                            <a href="/" class="btn btn-primary">от 1 000 ₽</a>
                        </div>

                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <i class="bi bi-chevron-compact-left text-primary fs-1"></i>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <i class="bi bi-chevron-compact-right text-primary fs-1"></i>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        </div>
    </div>

    <div class="container my-4 my-xxl-5 py-5">
        <div class="row g-4 g-md-5 justify-content-center align-items-center">
            <div class="col-xl-7 me-auto">

                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">
                    Лучшее только в Sk Bar
                </span>

                <h2 class="display-5 fw-semibold mb-5">События в ближайшие дни</h2>

            </div>
        </div>

        <div class="col-12">

            <div class="row row-cols-lg-3 row-cols-1 g-4">

                <div class="col">
                    <div
                        class="d-flex flex-column justify-content-between bg-body-tertiary p-4 p-xl-5 rounded h-100 text-wrap text-break  position-relative">

                        <div class="d-flex align-items-center justify-content-between mb-2 text-balance">
                            <span class="badge text-white"
                                style="background-color: #8f1de9; text-shadow: 0px 0px 0.5em #161822;">
                                Тестирование
                            </span>
                        </div>

                        <p class="fs-4 fw-bolder mb-2">
                            orchestra/testbench
                        </p>

                        <hr class="w-25">

                        <p class="line-clamp o-50 line-clamp-5 small">
                            Laravel Testing Helper for Packages Development
                        </p>


                        <div class="row justify-content-between">
                            <div class="col-auto d-inline-flex align-items-center me-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="me-2 text-warning"
                                    width="1em" height="1em" role="img" fill="currentColor" path="i.star-fill"
                                    componentname="icon">
                                    <polygon
                                        points="10 1.44 12.12 7.98 19 7.98 13.44 12.02 15.56 18.56 10 14.52 4.44 18.56 6.56 12.02 1 7.98 7.88 7.98 10 1.44">
                                    </polygon>
                                    <path
                                        d="m15.56,19.56c-.21,0-.41-.06-.59-.19l-4.97-3.61-4.97,3.61c-.35.26-.82.26-1.18,0-.35-.25-.5-.71-.36-1.12l1.9-5.85L.41,8.79c-.35-.25-.5-.71-.36-1.12s.52-.69.95-.69h6.15l1.9-5.85c.13-.41.52-.69.95-.69s.82.28.95.69l1.9,5.85h6.15c.43,0,.82.28.95.69s-.01.86-.36,1.12l-4.97,3.61,1.9,5.85c.13.41-.01.86-.36,1.12-.18.13-.38.19-.59.19Zm-5.56-6.04c.21,0,.41.06.59.19l3.07,2.23-1.17-3.61c-.13-.41.01-.86.36-1.12l3.07-2.23h-3.8c-.43,0-.82-.28-.95-.69l-1.17-3.61-1.17,3.61c-.13.41-.52.69-.95.69h-3.8l3.07,2.23c.35.25.5.71.36,1.12l-1.17,3.61,3.07-2.23c.18-.13.38-.19.59-.19Z">
                                    </path>
                                </svg>
                                2K
                            </div>
                            <div class="col">
                                <p class="text-end mb-0">
                                    <a href="https://github.com/orchestral/testbench"
                                        class="link-body-emphasis stretched-link icon-link icon-link-hover text-decoration-none">Перейти
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="bi"
                                            width="1em" height="1em" role="img" fill="currentColor"
                                            path="i.arrow-right" componentname="icon">
                                            <path
                                                d="m13,15c-.26,0-.51-.1-.71-.29-.39-.39-.39-1.02,0-1.41l3.29-3.29-3.29-3.29c-.39-.39-.39-1.02,0-1.41s1.02-.39,1.41,0l4,4c.39.39.39,1.02,0,1.41l-4,4c-.2.2-.45.29-.71.29Z">
                                            </path>
                                            <path
                                                d="m17,11H3c-.55,0-1-.45-1-1s.45-1,1-1h14c.55,0,1,.45,1,1s-.45,1-1,1Z">
                                            </path>
                                        </svg>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
