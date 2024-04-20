<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([[
            'name' => 'Супер админ',
            'guard_name' => 'web'
        ], [
            'name' => 'Админ',
            'guard_name' => 'web'
        ]]);

        Artisan::call('app:permissions');
    }
}
