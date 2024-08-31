<?php

namespace App\Services\Event\EventRegistration;

use App\Repositories\Event\EventRegistration\EventRegistrationRepositoryContract;
use App\Repositories\Event\EventRepositoryContract;
use App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper;

class EventRegistrationService implements EventRegistrationServiceContract
{
    private EventRepositoryContract $eventRepositoryContract;
    private EventRegistrationRepositoryContract $eventRegistrationRepository;

    public function __construct(EventRepositoryContract $eventRepositoryContract,
                                EventRegistrationRepositoryContract $eventRegistrationRepository)
    {
        $this->eventRepositoryContract = $eventRepositoryContract;
        $this->eventRegistrationRepository = $eventRegistrationRepository;
    }

    public function create(string $eventId, array $data, bool $confirm = false)
    {
        $data = array_merge($data, [
            'user_id' => auth()->user()->id,
            'event_id' => $eventId,
            'event_registration_status_id' => EventRegistrationStatusHelper::Confirmed
        ]);

        $this->eventRepositoryContract->incrementRegisteredUsers($eventId);

        return $this->eventRegistrationRepository->create($data);
    }
}
