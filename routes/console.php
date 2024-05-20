<?php

use App\Services\VkService;
use App\Jobs\VKAlbumsUpdate;
use App\Services\RKeeperService;


Schedule::call(function () {
    $rkService = new RKeeperService();

})->name('RKMenuUpdate')->hourly();


Schedule::call(function () {
    $vkService = new VkService();

    $albums = $vkService->getAlbums('-64982861');
    $albumsCache = $vkService->getCacheAlbums('-64982861');

    $albums->map(function ($album) use ($albumsCache, $vkService) {
        $id = $album['id'];
        $photos = $vkService->getCachePhotos('-64982861', $id);

        if($photos) dump(count($photos));
        if (!$albumsCache || !$albumsCache->has($id) || $albumsCache[$id]['size'] != $album['size'] || !$photos)
            VKAlbumsUpdate::dispatch('-64982861', $id);
    });

    $vkService->setCacheAlbums('-64982861', $albums);
})->name('VKAlbumsUpdate')->everyMinute();


Schedule::command('queue:work --max-time=300')->everyFiveMinutes();
