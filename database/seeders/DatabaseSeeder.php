<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTypeSeeder::class);
        $this->call(EventCategorySeeder::class);
        $this->call(PopularPlaceSeeder::class);
        $this->call(EventStatusSeeder::class);
        $this->call(EventRegistrationStatusSeeder::class);
    }
}
