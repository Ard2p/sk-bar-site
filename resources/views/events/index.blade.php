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
                    @include('events.parts.card')
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
