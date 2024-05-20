<?php

use App\Services\VkService;
use App\Jobs\VKAlbumsUpdate;

Schedule::call(function () {
    $vkService = new VkService();

    $vkService->clearAlbums('-64982861');

    $albums = $vkService->getAlbums('-64982861');
    $albumsCache = $vkService->getCacheAlbums('-64982861');

    $albums->map(function ($album) use ($albumsCache, $vkService) {
        $id = $album['id'];
        if (!$albumsCache || !$albumsCache->has($id) || $albumsCache[$id]['size'] != $album['size'])
            VKAlbumsUpdate::dispatch('-64982861', $id);
    });

    $vkService->setCacheAlbums('-64982861', $albums);
})->hourly();


Schedule::command('queue:work --max-time=300')->everyMinute()->withoutOverlapping();
