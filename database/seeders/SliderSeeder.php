<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('slider')->insert([
            'name' => 'Слайдер на Би-2 SK Bar (проверка|безсрочный)',
            'image' => 'slider.jpg',
            'link' => '/events/1',
            'status' => 'publish',
            'date_from' => null,
            'date_to' => null
        ]);
    }
}
