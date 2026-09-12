<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $timezones = [
            'Asia/Jakarta', 
            'Asia/Tokyo', 
            'Europe/London', 
            'America/New_York', 
            'UTC', 
            'Asia/Singapore', 
            'Australia/Sydney'
        ];

        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'preferred_timezone' => fake()->randomElement($timezones),
            'remember_token' => Str::random(10),
        ];
    }
}
