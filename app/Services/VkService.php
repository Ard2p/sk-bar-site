<?php

namespace App\Services;

use VK\Client\VKApiClient;
use Illuminate\Support\Facades\Cache;

class VkService
{
    protected $api;
    protected $token;

    public function __construct()
    {
        $this->api = new VKApiClient();
        $this->token = config('services.vk.token');
    }

    public function getAlbums(string $ownerId)
    {
        return $this->parse(collect($this->api->photos()->getAlbums($this->token, [
            'owner_id' => $ownerId,
            'need_covers' => 1,
            'photo_sizes' => 1
        ])['items'])->keyBy('id'));
    }

    public function getPhotos(string $ownerId, string $albumId = 'wall')
    {
        return $this->parse(collect($this->api->photos()->get($this->token, [
            'owner_id' => $ownerId,
            'album_id' => $albumId,
            'count' => 1000,
            'need_covers' => 1,
            'photo_sizes' => 1
        ])['items']));
    }

    public function getCacheAlbums(string $ownerId)
    {
        return Cache::get('vk::albums::' . $ownerId);
    }

    public function getCachePhotos(string $ownerId, string $albumId = 'wall')
    {
        return Cache::get('vk::photos::' . $ownerId . '::' . $albumId);
    }

    public function setCacheAlbums(string $ownerId, $albums)
    {
        Cache::forever('vk::albums::' . $ownerId, $albums);
    }

    public function createCacheAlbums(string $ownerId)
    {
        Cache::forever('vk::albums::' . $ownerId, $this->getAlbums($ownerId));
    }

    public function createCachePhotos(string $ownerId, string $albumId = 'wall')
    {
        Cache::forever('vk::photos::' . $ownerId . '::' . $albumId, $this->getPhotos($ownerId, $albumId));
    }

    public function clearAlbums(string $ownerId)
    {
        Cache::forget('vk::albums::' . $ownerId);
    }

    public function clearPhotos(string $ownerId, string $albumId)
    {
        Cache::forget('vk::photos::' . $ownerId . '::' . $albumId);
    }

    protected function parse($items)
    {
        return $items->map(fn (array $photo) => [
            'id' => $photo['id'],
            'size' => $photo['size'] ?? $photo['sizes'],
            'title' => $photo['title'] ?? $photo['text'],
            'created' => $photo['created'] ?? $photo['date'],
            'photo' => $this->parseSizes($photo['sizes'])
        ]);
    }

    protected function parseSizes($sizes)
    {
        $sizes = collect($sizes)->keyBy('type');
        return collect([
            'small' => $sizes['q'],
            'big' => $sizes['w'] ?? $sizes['z'] ?? $sizes['x']
        ])->select(['type', 'height', 'width', 'url']);
    }
}
