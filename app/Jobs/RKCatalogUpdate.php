<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\RKProduct;
use App\Models\RKCategory;
use App\Services\RKService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RKCatalogUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $maxExceptions = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rkService = new RKService();
        $catalog = $rkService->getCatalog();

        $now = Carbon::now();
        $categories = [];
        $products = [];

        $rkCategories = RKCategory::orderBy('position')->get()->keyBy('ident');

        foreach ($catalog as $category) {
            $rkCategory = $rkCategories[$category->ident] ?? null;
            $rkProducts =  $rkCategory?->products?->keyBy('ident');

            foreach ($category?->products as $product) {
                $rkProduct = $rkProducts[$product->ident] ?? null;

                $product->position = $rkProduct?->position ?? null;
                $product->created_at = $now;
                $product->updated_at = $now;

                $products[] = (array)$product;
            }
            unset($category->products);

            $category->position = $rkCategory?->position ?? null;
            $category->created_at = $now;
            $category->updated_at = $now;

            $categories[] = (array)$category;
        }

        DB::transaction(function () use ($categories, $products) {
            RKCategory::query()->delete();
            RKCategory::insert($categories);

            RKProduct::query()->delete();
            RKProduct::insert($products);
        });
    }
}
