<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        // Generate random date between 1 and 30 days from now
        // Set time to between 02:00 and 06:00 UTC (safe for 08:00-17:00 in many timezones)
        $start = Carbon::now()->addDays(rand(1, 30))->setTime(rand(2, 6), rand(0, 59), 0)->utc();
        
        return [
            'title' => fake()->sentence(3),
            'creator_id' => User::factory(),
            'start' => $start,
            'end' => $start->copy()->addHours(rand(1, 2)),
        ];
    }
}
