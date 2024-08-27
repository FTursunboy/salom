<?php

namespace App\Repositories\Locations\Country;

interface CountryRepositoryContract
{
    public function findOrNew(string $name);
}
