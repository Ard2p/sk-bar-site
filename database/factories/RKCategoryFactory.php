<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RKCategoryFactory extends Factory
{

    public function definition(): array
    {
        return [
            'ident' => fake()->unique()->randomNumber(),
            'code' => fake()->unique()->randomNumber(),
            'name' => fake()->name(),
            'position' => fake()->randomNumber(),
        ];
    }
}
