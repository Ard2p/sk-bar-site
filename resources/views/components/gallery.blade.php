@props(['items'])

<div class="row row-cols-lg-6 row-cols-md-3 row-cols-1 g-1 gallery">
    @foreach ($items as $item)
        <div class="col">
            <div class="ratio ratio-1x1">
                <a href="{{ $item['photo']['big']['url'] }}">
                    <img src="{{ $item['photo']['small']['url'] }}" class="d-block object-fit-cover w-100 h-100">
                </a>
            </div>
        </div>
    @endforeach
</div>

<link rel="stylesheet" href="/vendor/simplelightbox/simple-lightbox.min.css" />
<script src="/vendor/simplelightbox/simple-lightbox.min.js"></script>

<script>
    (function() {
        var $gallery = new SimpleLightbox('.gallery a', {});
    })();
</script>
