<?php

namespace App\Repositories\Event\EventCategory;

use App\Models\Event\EventCategory\EventCategory;
use Illuminate\Support\Collection;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Event\EventCategory\_IH_EventCategory_C;

class EventCategoryEloquentRepository implements EventCategoryRepositoryContract
{
    protected EventCategory $eventCategory;

    public function __construct(EventCategory $eventCategory)
    {
        $this->eventCategory = $eventCategory;
    }

    public function listAll(): Collection
    {
        return $this->eventCategory->query()
            ->orderBy('name')->get()
            ->pluck('name', 'id');
    }

    public function getCategoriesWithEvents(string $date): array|\Illuminate\Database\Eloquent\Collection|_IH_EventCategory_C|_IH_BaseModel_C
    {
        return $this->eventCategory::query()
            ->select('event_categories.*')
            ->with(['last_events'])
            ->has('last_events')
            ->join('events', 'events.event_category_id', '=', 'event_categories.id')
            ->join('event_schedules', 'event_schedules.event_id', '=', 'events.id')
            ->where('event_schedules.start_date', '=', $date)
            ->get();
    }
}
