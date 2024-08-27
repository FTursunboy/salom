<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Repositories\Event\EventRegistration\EventRegistrationRepositoryContract;
use App\Repositories\Event\EventRepositoryContract;
use App\Repositories\Favorite\FavoriteRepositoryContract;

class EventController extends Controller
{
    private EventRepositoryContract $eventRepository;
    private FavoriteRepositoryContract $favoriteRepository;
    private EventRegistrationRepositoryContract $eventRegistrationRepository;

    public function __construct(EventRepositoryContract $eventRepository,
                                FavoriteRepositoryContract $favoriteRepository,
                                EventRegistrationRepositoryContract $eventRegistrationRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->eventRegistrationRepository = $eventRegistrationRepository;
    }

    public function show(Event $event)
    {
        $favorite = null;
        if (auth()->user()) {
            $favorite = $this->favoriteRepository->findByUserAndEvent(auth()->user()->id, $event->id);
        }

        $schedules = $event->schedules->groupBy('start_date');
        $this->eventRepository->updateViewCount($event->id);

        $registrations = [];

        if (auth()->user()) {
            $registrations = $this->eventRegistrationRepository->getByEventAndUser($event->id, auth()->user()->id);
        }

        /*$schedulesForRegistration = [];
        foreach ($event->schedules as $item) {
            $schedulesForRegistration[$item->id] = $item->title . ' - ' .
                $item->start_date->translatedFormat('d M Y(D)') . ' ' .
                $item->start_time->translatedFormat('H:i');
        }*/

        return view('profile.events.show', compact('event', 'schedules', 'registrations', 'favorite'));
    }
}
