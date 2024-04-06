<div class="swiper rounded shadow-sm menu-slider">
    <div class="swiper-wrapper">

        @for ($i = 0; $i < 20; $i++)
            <div class="swiper-slide ratio ratio-1x1 d-flex item">
                <div class="d-flex flex-column align-items-center justify-content-center">

                    <div>
                        <img src="{{ asset('storage/closedPizza.webp') }}">
                    </div>

                    <span class="">Закрытая</span>

                </div>
            </div>
        @endfor

    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper('.swiper', {
        slidesPerView: 10,
        breakpoints: {
            320: {
                slidesPerView: 3
            },
            400: {
                slidesPerView: 4
            },
            500: {
                slidesPerView: 5
            },
            768: {
                slidesPerView: 7
            },
            992: {
                slidesPerView: 9
            },
            1200: {
                slidesPerView: 10
            }
        }
    })
</script>
