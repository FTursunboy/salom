<?php

namespace App\Repositories\PopularPlace;

use App\Models\PopularPlace\PopularPlace;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\PopularPlace\_IH_PopularPlace_C;

class PopularPlaceEloquentRepository implements PopularPlaceRepositoryContract
{
    protected PopularPlace $popularPlace;

    public function __construct(PopularPlace $popularPlace)
    {
        $this->popularPlace = $popularPlace;
    }

    public function

    all(): array|Collection|_IH_PopularPlace_C|\Illuminate\Support\Collection
    {
        return $this->popularPlace::query()->orderBy('name')->get();
    }
}
