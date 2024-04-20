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

        if(seo()->meta()->description())
            $og['description'] = seo()->meta()->description();

        foreach ($parameters as $parameter) {
            if ($parameter instanceof Model) {
                // seo()->title('SK Bar | ' . ($seo->title ?? $parameter->title ?? $parameter->name));

                seo()->title($seo->title ?? $parameter->title ?? $parameter->name);
                $og['title'] = seo()->meta()->title();

                if($parameter->image || $parameter->photo)
                    $og['image'] = asset('storage/' . ($parameter->image ?? $parameter->photo));
            }
        }

        seo()->og($og);
    }

    //     seo()->meta()->keywords()
    //     seo()->meta()->text()
}
