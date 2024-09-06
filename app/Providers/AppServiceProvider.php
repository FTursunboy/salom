<?php

namespace App\Providers;

use App\Gateway\Sms\OsonSmsGateway;
use App\Gateway\Sms\SmsGatewayContract;
use App\Models\Locations\City\City;
use App\Repositories\Event\EventCategory\EventCategoryEloquentRepository;
use App\Repositories\Event\EventCategory\EventCategoryRepositoryContract;
use App\Repositories\Event\EventEloquentRepository;
use App\Repositories\Event\EventRegistration\EventRegistrationEloquentRepository;
use App\Repositories\Event\EventRegistration\EventRegistrationRepositoryContract;
use App\Repositories\Event\EventRepositoryContract;
use App\Repositories\Event\EventSchedule\EventScheduleEloquentRepository;
use App\Repositories\Event\EventSchedule\EventScheduleRepositoryContract;
use App\Repositories\Favorite\FavoriteEloquentRepository;
use App\Repositories\Favorite\FavoriteRepositoryContract;
use App\Repositories\Locations\City\CityEloquentRepository;
use App\Repositories\Locations\City\CityRepositoryContract;
use App\Repositories\Locations\Country\CountryEloquentRepository;
use App\Repositories\Locations\Country\CountryRepositoryContract;
use App\Repositories\PopularPlace\PopularPlaceEloquentRepository;
use App\Repositories\PopularPlace\PopularPlaceRepositoryContract;
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\User\UserRepositoryContract;
use App\Services\Common\Image\ImageService;
use App\Services\Common\Image\ImageServiceContract;
use App\Services\Event\EventRegistration\EventRegistrationService;
use App\Services\Event\EventRegistration\EventRegistrationServiceContract;
use App\Services\Profile\ProfileEvent\ProfileEventContract;
use App\Services\Profile\ProfileEvent\ProfileEventService;
use App\Services\User\UserService;
use App\Services\User\UserServiceContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();

        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('verifySmsCode', function ($attribute, $value, $parameters, $validator) {
            return auth()->user()->checkSmsCode($value);
        });

        if (\App::environment('local')) {

            \DB::listen(function ($query) {
                \Log::info(
                    $query->sql,
                    [$query->bindings,
                    $query->time]
                );
            });
        }
    }

    protected function registerRepositories(): void
    {
        $this->app->bind(EventCategoryRepositoryContract::class, EventCategoryEloquentRepository::class);
        $this->app->bind(PopularPlaceRepositoryContract::class, PopularPlaceEloquentRepository::class);
        $this->app->bind(EventRepositoryContract::class, EventEloquentRepository::class);
        $this->app->bind(CountryRepositoryContract::class, CountryEloquentRepository::class);
        $this->app->bind(CityRepositoryContract::class, CityEloquentRepository::class);
        $this->app->bind(EventRegistrationRepositoryContract::class, EventRegistrationEloquentRepository::class);
        $this->app->bind(EventScheduleRepositoryContract::class, EventScheduleEloquentRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserEloquentRepository::class);
        $this->app->bind(FavoriteRepositoryContract::class, FavoriteEloquentRepository::class);
    }

    protected function registerServices(): void
    {
        $this->app->bind(SmsGatewayContract::class, OsonSmsGateway::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(ImageServiceContract::class, ImageService::class);
        $this->app->bind(ProfileEventContract::class, ProfileEventService::class);
        $this->app->bind(EventRegistrationServiceContract::class, EventRegistrationService::class);
    }
}
