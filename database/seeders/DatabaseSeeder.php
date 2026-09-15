<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Re-create the admin user
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin User',
                'preferred_timezone' => 'Asia/Jakarta',
            ]
        );

        // 2. Create 10 dummy appointments for the admin so the list page has data
        // Tapi TIDAK ADA dummy users lain, sehingga dropdown Invitees kosong/bersih.
        Appointment::factory(10)->create([
            'creator_id' => $admin->id,
        ]);
    }
}
