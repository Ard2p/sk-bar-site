<x-app-layout>

    <div class="container mb-5">

        <x-caption sub="Лучшее только в Sk Bar">Меню</x-caption>

        <x-menu-swiper />

        @for ($i1 = 0; $i1 < 0; $i1++)
            <div class="row justify-content-between">

                @for ($i2 = 0; $i2 < 2; $i2++)
                    <div class="col-5">

                        @for ($i3 = 0; $i3 < 2; $i3++)
                            <div class="mb-5">

                                <h4 class="text-white">ВИНО</h4>

                                <div>

                                    <div class="text-primary mt-4 mb-3 d-block text-uppercase fw-semibold ls-xl">РОССИЯ
                                    </div>

                                    <ul class="list-group text-white">
                                        <li class="row mb-3">
                                            <div class="col-7">
                                                <div>Эссе Шардоне</div>
                                                <sub class="">Esse Chardonnay</sub>
                                            </div>
                                            <div class="col-5 d-flex justify-content-between">
                                                <div>3&nbsp;250&nbsp;₽</div>
                                                <div>750 мл</div>
                                            </div>
                                        </li>
                                        <li class="row mb-3">
                                            <div class="col-7">
                                                <div>Эссе Саперави Хевен</div>
                                                <sub class="">Esse Saperavi Heaven</sub>
                                            </div>
                                            <div class="col-5 d-flex justify-content-between">
                                                <div>3&nbsp;450&nbsp;₽</div>
                                                <div>750 мл</div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                                @for ($i = 0; $i < 3; $i++)
                                    <div>

                                        <div class="text-primary mt-4 mb-3 d-block text-uppercase fw-semibold ls-xl">
                                            ФРАНЦИЯ
                                        </div>

                                        <ul class="list-group text-white">

                                            <li class="row mb-3">
                                                <div class="col-7">
                                                    <div>Шато О Бон Фис Бордо (красное, сухое)</div>
                                                    <sub>Chateau Haut Bon Fils Bordeaux AOC</sub>
                                                </div>
                                                <div class="col-5 d-flex justify-content-between">
                                                    <div>2&nbsp;100&nbsp;₽</div>
                                                    <div>750 мл</div>
                                                </div>
                                            </li>

                                            <li class="row mb-3">
                                                <div class="col-7">
                                                    <div>Анжу Розе (розовое, полусладкое)</div>
                                                    <sub>Anjou Rose AOC</sub>
                                                </div>
                                                <div class="col-5 d-flex justify-content-between">
                                                    <div>3&nbsp;600&nbsp;₽</div>
                                                    <div>750 мл</div>
                                                </div>
                                            </li>

                                        </ul>

                                    </div>
                                @endfor

                            </div>
                        @endfor

                    </div>
                @endfor

            </div>
        @endfor

    </div>

</x-app-layout>
