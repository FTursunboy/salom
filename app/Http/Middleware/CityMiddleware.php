<?php

namespace App\Http\Middleware;

use App\Models\Locations\City\City;
use Closure;
use Illuminate\Http\Request;
use Psr\SimpleCache\InvalidArgumentException;
use function PHPUnit\Framework\isEmpty;

class CityMiddleware
{
    /**
     * @throws InvalidArgumentException
     */
    public function handle(Request $request, Closure $next)
    {
        $cities = City::all();

        if (is_null(\Cache::get('currentCity'))) {
            \Cache::put('currentCity', 'Все города');
        }
        if ($request->get('city') == 'all') {
            \Cache::delete('currentCityId');
            \Cache::put('currentCity', 'Все города');
        }
        else {
            $currentCity = $cities->where('name', '=', $request->get('city'))->first();
            if ($currentCity) {
                \Cache::put('currentCityId', $currentCity->id);
                \Cache::put('currentCity', $currentCity->name);
            }
        }

        view()->share('cities', $cities);

        return $next($request);
    }
}
