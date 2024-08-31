<?php

namespace App\Services\Profile\ProfileEvent;

use App\Models\Event\Event;
use App\Repositories\Event\EventRepositoryContract;
use App\Repositories\Locations\City\CityRepositoryContract;
use App\Repositories\Locations\Country\CountryRepositoryContract;

class ProfileEventService implements ProfileEventContract
{
    private CityRepositoryContract $cityRepository;
    private EventRepositoryContract $eventRepository;
    private CountryRepositoryContract $countryRepository;

    public function __construct(CityRepositoryContract $cityRepository,
                                EventRepositoryContract $eventRepository,
                                CountryRepositoryContract $countryRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->eventRepository = $eventRepository;
        $this->countryRepository = $countryRepository;
    }

    public function create(array $data)
    {

        $data = array_merge($data, [
            'address' => 'RUMON',
            'show_ticket_count' => ($data['show_ticket_count'] ?? null == 'on')
        ]);

        return $this->eventRepository->create($data);
    }

    public function update(string $id, array $data)
    {
        $country = $this->countryRepository->findOrNew($data['country']);
        $city = $this->cityRepository->findOrNew($country->id, $data['city']);

        unset($data['country']);
        unset($data['city']);
        $data = array_merge($data, [
            'country_id' => $country->id,
            'city_id' => $city->id,
            'show_ticket_count' => ($data['show_ticket_count'] ?? null == 'on')
        ]);

        return $this->eventRepository->update($id, $data);
    }

    public function destroy(string $id): Event
    {
        $event = Event::find($id);

        $event->is_active = false;
        $event->save();

        return $event;
    }
}
