<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->title(),
            'image' => fake()->imageUrl($width=500, $height=400),
            'gallery' => fake()->imageUrl($width=500, $height=400),
            'banner' => fake()->imageUrl($width=500, $height=400),
            'description' =>  fake()->paragraph(),
            'event_start' => now(),
            'guest_start' => now(),
            'recommendation' => fake()->boolean(),
            'status' => 'publish',
            'age_limit' => array_rand(['0', '6', '12', '16', '18']),
            'place_id' => Place::all()->random(),
            // 'genre_id' => Genre::all()->random(),
        ];
    }
}
