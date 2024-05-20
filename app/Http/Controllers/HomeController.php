<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Slider;
use App\Services\VkService;
use App\Services\RKeeperService;

class HomeController extends Controller
{
    public function index()
    {
        $vkService = new VkService();
        $rkService = new RKeeperService();

        // dd($rkService->getMenu());
        // return $rkService->getMenu();

        return view('home', [
            'vk_albums' => $vkService->getCacheAlbums('-64982861')->slice(0, 18),
            'slider' => Slider::active()->period()->get(),
            'coming_events' => Event::active()->actual()->orderBy('event_start')->limit(4)->get(),
            'recommended_events' => Event::active()->actual()->recommendation()->limit(4)->get()
        ]);
    }
}
