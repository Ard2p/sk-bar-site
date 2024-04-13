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
            'content' => 'Бронь столов, заказ билетов - ☎ 36-26-26',
            'map' => 'https://yandex.ru/map-widget/v1/?um=constructor%3Aed9e4d1da33fc1eb2311f8041fa5ae5ac98ac6b4b933ff25222f39642bbef391&amp;source=constructor&amp;scroll=false',
        ]);
    }
}
