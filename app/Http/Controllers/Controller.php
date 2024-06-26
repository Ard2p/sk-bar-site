<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Leeto\Seo\Seo;

abstract class Controller
{
    public function __construct()
    {
        $seo = seo()->cachedByUrl();
        $parameters = request()->route()->parameters();
        $og = [
            'url' => request()->url(),
            'title' => seo()->meta()->title(),
        ];

        seo()->title(seo()->meta()->title());
        seo()->description(seo()->meta()->description());

        if (seo()->meta()->description())
            $og['description'] = seo()->meta()->description();

        $isModel = false;
        foreach ($parameters as $parameter) {
            if ($parameter instanceof Model) {
                $isModel = true;

                seo()->title($seo->title ?? $parameter->title ?? $parameter->name);
                $og['title'] = seo()->meta()->title();

                if ($parameter->image || $parameter->photo)
                    $og['image'] = asset('storage/' . ($parameter->image ?? $parameter->photo));
            }
        }

        if (!$isModel) $og['image'] = asset('/android-chrome-192x192.png');

        seo()->og($og);
    }

    public function setSeo($title = '', $description = '', $image = '')
    {

        $seo = seo()->cachedByUrl();
        $title = $seo->title ?? $title ?? seo()->meta()->title();

        seo()->title($title);
        seo()->description($seo->description ?? $description ?? seo()->meta()->description());

        $og = [
            'url' => request()->url(),
            'title' => $title,
        ];

        if ($image) $og['image'] = $image;

        seo()->og($og);
    }
}
