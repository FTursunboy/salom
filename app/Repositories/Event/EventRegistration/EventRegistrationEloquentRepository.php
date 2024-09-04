<?php

namespace App\Repositories\Event\EventRegistration;

use App\Models\Event\EventRegistration\EventRegistration;
use App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Event\EventRegistration\_IH_EventRegistration_C;

class EventRegistrationEloquentRepository implements EventRegistrationRepositoryContract
{
    private EventRegistration $eventRegistration;

    public function __construct(EventRegistration $eventRegistration)
    {
        $this->eventRegistration = $eventRegistration;
    }

    public function create(array $data)
    {
        return $this->eventRegistration::create($data);
    }

    public function getByEventAndUser(string $eventId, string $userId): _IH_EventRegistration_C|array|Collection|_IH_BaseModel_C
    {
        return $this->eventRegistration::query()
            ->with(['event_registration_status'])
            ->where('user_id', '=', $userId)
            ->where('event_id', $eventId)
            ->get();
    }

    public function getAllRegistrations(string $eventId): _IH_EventRegistration_C|array|Collection|\Illuminate\Support\Collection|_IH_BaseModel_C
    {
        return $this->eventRegistration::query()
            ->with(['event_registration_status', 'user'])
            ->where('event_id', $eventId)
            ->orderByDesc('created_at')
            ->get();
    }

    public function confirm(string $id): array|_IH_EventRegistration_C|Collection|EventRegistration|\App\Models\BaseModel|_IH_BaseModel_C|\Illuminate\Database\Eloquent\Model|null
    {
        $eventRegistration = $this->eventRegistration::find($id);
        $eventRegistration->event_registration_status_id = EventRegistrationStatusHelper::Confirmed;
        $eventRegistration->save();

        return $eventRegistration;
    }

    public function cancel(string $id): array|_IH_EventRegistration_C|Collection|EventRegistration|\App\Models\BaseModel|_IH_BaseModel_C|\Illuminate\Database\Eloquent\Model|null
    {
        $eventRegistration = $this->eventRegistration::find($id);
        $eventRegistration->event_registration_status_id = EventRegistrationStatusHelper::Canceled;
        $eventRegistration->save();

        return $eventRegistration;
    }
}
