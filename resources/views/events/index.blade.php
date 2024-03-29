<x-app-layout>

    <div class="container">

        <div class="row g-4 g-md-5 justify-content-center align-items-center">
            <div class="col-xl-7 me-auto">

                <span class="text-primary mb-3 d-block text-uppercase fw-semibold ls-xl">
                    Лучшее только в Sk Bar
                </span>

                <h2 class="display-5 fw-semibold mb-5">Афиша Мероприятий</h2>

            </div>
        </div>

        <div class="row mb-5">

            <div class="col-auto">
                <select name="city" id="select_city">
                    <option value="">Город</option>

                </select>
            </div>

            <div class="col-auto">
                <select name="select_box" id="select_box">
                    <option value="">Артист</option>

                </select>
            </div>

        </div>

        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-4">

            @for ($i = 0; $i < 12; $i++)
                <div @class(['col', 'mb-3'])>
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
