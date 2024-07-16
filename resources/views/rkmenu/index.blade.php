<x-app-layout>

    <div class="container mb-5">

        <x-caption sub="Лучшее только в Sk Bar">Меню</x-caption>

        {{-- <div class="col my-5">
            <x-menu-swiper />
        </div> --}}

        @if ($menu)

            @foreach ($menu as $category)
                @if (count($category->products) > 0)
                    <h4 class="mt-3 fw-bold text-primary">{{ $category->name }}</h4>

                    <div class="row row-cols-xxl-4 row-cols-lg-3 row-cols-2 g-4 mb-5">

                        @foreach ($category->products as $product)
                            <div class="col mt-5">
                                <div class="d-flex h-100 flex-column">

                                    @if ($product->image)
                                        <div class="ratio ratio-5x4">
                                            <div></div>
                                        </div>
                                    @endif

                                    <div class="h-100 d-flex flex-column">
                                        <div class="fs-5 fw-bold">{{ $product->name }}</div>

                                        <div class="small my-2">
                                            <div>{{ $product->instruct }}</div>
                                        </div>


                                        <div class="d-flex justify-content-between mt-auto">
                                            <div class="ms-auto1 fw-bold badge text-white bg-primary">{{ $product->price / 100 }}р</div>
                                            {{-- <a class="btn btn-primary text-white">Купить</a> --}}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
            @endforeach

        @endif

    </div>

</x-app-layout>
