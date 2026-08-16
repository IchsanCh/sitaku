<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Package;
use App\Models\Tier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            TierFeatureSeeder::class,
        ]);

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

        $basicTier = Tier::where('slug', 'basic')->first();
        $premiumTier = Tier::where('slug', 'premium')->first();

        Package::create([
            'tier_id' => $basicTier?->id,
            'name' => 'Basic',
            'description' => 'Langganan 1 Bulan',
            'price' => '150000',
            'duration_days' => '30',
        ]);

        Package::create([
            'tier_id' => $basicTier?->id,
            'name' => 'Trial 7 Hari',
            'description' => 'Trial otomatis 7 hari buat user baru',
            'price' => '0',
            'duration_days' => '7',
            'visible'=> 'private',
        ]);

        Package::create([
            'tier_id' => $premiumTier?->id,
            'name' => 'Premium',
            'description' => 'Langganan 1 Bulan - Premium',
            'price' => '175000',
            'duration_days' => '30',
        ]);
    }
}