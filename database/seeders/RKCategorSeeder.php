<?php

namespace Database\Seeders;


use App\Models\RKCategory;
use Illuminate\Database\Seeder;

class RKCategorSeeder extends Seeder
{
    public function run(): void
    {
        RKCategory::factory()->count(20)->create();
    }
}
