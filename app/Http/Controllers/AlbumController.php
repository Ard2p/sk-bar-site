<?php

namespace App\Http\Controllers;

use App\Services\VkService;

class AlbumController extends Controller
{
    public function index()
    {
        $vkService = new VkService();

        return view('albums.index', [
            'vk_albums' => $vkService->getCacheAlbums('-64982861'),
        ]);
    }

    public function show($id)
    {
        $vkService = new VkService();
        $album = $vkService->getCacheAlbums('-64982861')[$id];

        $this->setSeo($album['title'], image: $album['photo']['small']['url']);

        return view('albums.show', [
            'album' => $album,
            'vk_photos' => $vkService->getCachePhotos('-64982861', $id),
        ]);
    }
}
