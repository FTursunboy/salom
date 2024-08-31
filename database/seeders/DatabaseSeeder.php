<?php

namespace Database\Seeders;

use App\Models\Locations\City\City;
use App\Models\Locations\Country\Country;
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

        Country::create([
            'id' => 1,
            'name' => 'Таджикистан',
            'is_active' => true,
        ]);

        City::create([
            'id' => 1,
            'country_id' => 1,
            'name' => 'Khujand'
        ]);
    }
}
