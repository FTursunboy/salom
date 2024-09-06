<?php

namespace Database\Seeders;

use App\Models\Locations\City\City;
use App\Models\Locations\Country\Country;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::create([
           'first_name' => 'fd',
           'user_type_id' => '267777f0-4304-11ee-9288-00ff535e960d',
            'last_name' => 'dfsa',
            'telegram' => 'fd',
            'phone' => '99292771891',
            'phone_verified_at' => '2024-08-31 20:45:12',
            'sms_code' => 41351,
            'password' => Hash::make('password123')

        ]);
    }
}
