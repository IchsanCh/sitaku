<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::create([
            'name' => 'Ichsan',
            'email' => 'test@gmail.com',
            'password' => bcrypt('123')
        ]);
        User::create([
            'name' => 'Test',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'email_verified_at' => now(),
        ]);
        Package::create([
            'name' => 'Basic',
            'description' => 'Langganan 1 Bulan',
            'price' => '5',
            'duration_days' => '30',
        ]);
    }
}
