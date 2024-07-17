<x-guest-layout>

    <div class="container mb-5">

        <span class="text-primary mb-1 d-block text-uppercase fw-semibold ls-xl">Лучшее только в Sk Bar</span>

        <h2 class="display-5 fw-semibold mb-5">Бронирование столов</h2>

        <div class="row" x-data="{
            step: 1,
            tables: {},
            async getReservs() {
                {{-- this.tables = await (await fetch('/api/reserv/1')).json();
                console.log(this.tables); --}}
            }
        }" x-init="getReservs">

            <div class="row" x-show="step == 1">

                <div class="col-4">
                    инфо о концерте
                </div>

                <div class="col-8">
                    {!! file_get_contents(public_path('shemes/skbar-1.svg')) !!}
                </div>

            </div>

            <div x-show="step == 2">
                2
            </div>

            <div x-show="step == 3">
                3
            </div>

            <div class="row">
                <button x-show="step == 1" @click="step = 2" class="btn btn-primary text-white">Дальше</button>
                <button x-show="step == 2" @click="step = 1" class="btn btn-primary text-white">Назад</button>

                <button x-show="step == 2" @click="step = 3" class="btn btn-primary text-white">Подтвердить</button>
            </div>

        </div>

    </div>

</x-guest-layout>
