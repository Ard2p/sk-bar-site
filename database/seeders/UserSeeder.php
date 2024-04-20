<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([[
            'name' => 'Дмитрий',
            'email' => 'ard2p@bk.ru',
            'password' => Hash::make('123456'),
        ], [
            'name' => 'Александр',
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('123456'),
        ]]);

        DB::table('model_has_roles')->insert([[
            'role_id' => 1,
            'model_type' => User::class,
            'model_id' => 1,
        ], [
            'role_id' => 1,
            'model_type' => User::class,
            'model_id' => 2,
        ]]);
    }
}
