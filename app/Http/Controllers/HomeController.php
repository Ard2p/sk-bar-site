<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Slider;
use VK\Client\VKApiClient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache::forget('vk::albums');
        $vkAlbums = Cache::remember('vk::albums', now()->addHours(4), function () {
            $vk = new VKApiClient();
            return collect($vk->photos()->getAlbums(config('services.vk.token'), [
                'owner_id' => '-64982861',
                'count' => 18,
                'need_covers' => 1,
                'photo_sizes' => 1
            ])['items'])->map(function (array $photo) {
                return [
                    'id' => $photo['id'],
                    'size' => $photo['size'],
                    'title' => $photo['title'],
                    'created' => $photo['created'],
                    'photo' => collect($photo['sizes'])
                        ->whereIn('type', ['q', 'w'])
                        ->map(function (array $size) {
                            $size['type'] = Str::replace('q', 'small', $size['type']);
                            $size['type'] = Str::replace('w', 'big', $size['type']);
                            return $size;
                        })
                        ->keyBy('type')
                        ->select(['height', 'width', 'url'])
                ];
            });
        });

        return view('home', [
            'vk_albums' => $vkAlbums,
            'slider' => Slider::active()->period()->get(),
            'coming_events' => Event::active()->actual()->orderBy('event_start')->limit(4)->get(),
            'recommended_events' => Event::active()->actual()->recommendation()->limit(4)->get()
        ]);
    }
}
