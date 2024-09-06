<?php

namespace App\Repositories\Event\EventRegistration;

interface EventRegistrationRepositoryContract
{
    public function create(array $data);

    public function getByEventAndUser(string $eventId, string $userId);

    public function getAllRegistrations(string $eventId);

    public function confirm(string $id);

    public function cancel(string $id);
}
