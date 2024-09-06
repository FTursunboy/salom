<?php

namespace App\Repositories\Locations\City;

interface CityRepositoryContract
{
    public function findOrNew(string $country_id, string $name);
}
