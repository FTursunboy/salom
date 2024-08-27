<?php

namespace App\Services\Event\EventRegistration;

use App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper;

interface EventRegistrationServiceContract
{
    public function create(string $eventId, array $data, bool $confirm = false);
}
