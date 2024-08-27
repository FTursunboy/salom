<?php

namespace App\Repositories\Locations\City;

use App\Models\Locations\City\City;

class CityEloquentRepository implements CityRepositoryContract
{
    private City $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function findOrNew(string $country_id, string $name)
    {
        $city = $this->city::query()
            ->where('country_id', '=', $country_id)
            ->where('name', '=', $name)->first();

        if (empty($city)) {
            $city = $this->city::create(['name' => $name, 'country_id' => $country_id]);
        }

        return $city;
    }
}
