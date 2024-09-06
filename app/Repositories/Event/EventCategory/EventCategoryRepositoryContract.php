<?php

namespace App\Repositories\Event\EventCategory;

interface EventCategoryRepositoryContract
{
    public function listAll();

    public function getCategoriesWithEvents(string $date);
}
