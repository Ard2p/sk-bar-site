<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('places')->insert([
            'name' => 'SK Bar',
            'city' => 'Чебоксары',
            'adress' => 'ул. Карла Маркса, 47',
        ]);
    }
}
