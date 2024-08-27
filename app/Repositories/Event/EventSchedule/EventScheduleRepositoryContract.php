<?php

namespace App\Repositories\Event\EventSchedule;

interface EventScheduleRepositoryContract
{
    public function findById(string $id);
}
