<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Slider;
use App\Services\VkService;
use SergiX44\Nutgram\Nutgram;


class HomeController extends Controller
{
    public function index()
    {
        $vkService = new VkService();

        return view('home', [
            'vk_albums' => $vkService->getCacheAlbums('-64982861')?->slice(0, 18),
            'slider' => Slider::active()->period()->get(),
            'coming_events' => Event::limit(4)->get(),
            'recommended_events' => Event::recommendation()->limit(4)->get()
        ]);
    }

    public function telegramWebhook(Nutgram $bot)
    {
        $bot->run();
    }
}
