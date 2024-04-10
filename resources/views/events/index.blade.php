<x-app-layout>

    <div class="container mb-5">

        <x-caption sub="Лучшее только в Sk Bar">Афиша Мероприятий</x-caption>

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

        @include('events.parts.list', ['col_lg' => 4, 'col_md' => 2, 'items' => $events])

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
