<?php

namespace App\Repositories\Event\EventSchedule;

use App\Models\Event\EventSchedule\EventSchedule;

class EventScheduleEloquentRepository implements EventScheduleRepositoryContract
{
    private EventSchedule $eventSchedule;

    public function __construct(EventSchedule $eventSchedule)
    {
        $this->eventSchedule = $eventSchedule;
    }

    public function findById(string $id): EventSchedule
    {
        return $this->eventSchedule::find($id);
    }
}
