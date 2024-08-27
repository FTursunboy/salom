<?php

namespace App\Repositories\Locations\Country;

use App\Models\Locations\Country\Country;

class CountryEloquentRepository implements CountryRepositoryContract
{
    private Country $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function findOrNew(string $name)
    {
        $country = $this->country::query()->where('name', '=', $name)->first();
        if (empty($country)) {
            $country = $this->country::create(['name' => $name]);
        }

        return $country;
    }
}
