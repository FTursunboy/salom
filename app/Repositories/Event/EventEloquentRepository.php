<?php

namespace App\Repositories\Event;

use App\Models\BaseModel;
use App\Models\Event\Event;
use App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_BaseModel_C;
use LaravelIdea\Helper\App\Models\Event\_IH_Event_C;
use Ramsey\Uuid\Uuid;

class EventEloquentRepository implements EventRepositoryContract
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function create(array $data)
    {
        $data = array_merge($data, [
            'created_by_user_id' => auth()->user()->id,
            'event_status_id' => EventStatusHelper::Confirmed,
            'show_ticket_count' => ($data['show_ticket_count'] ?? null) == 'on',
            'free_entrance' => ($data['free_entrance'] ?? null) == 'on',
        ]);

        foreach ($data['event_schedules'] as &$v) {
            $v['id'] = Uuid::uuid4();
        }

        $event = $this->event::create($data);
        $event->event_schedules()->sync($data['event_schedules']);

        return $event;
    }

    public function paginateByUserId(string $userId, array $data = [], $perPage = 12, array $columns = ['*']): array|LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator|_IH_BaseModel_C|_IH_Event_C
    {
        return $this->event->query()->select($columns)
            ->with(['event_status', 'created_by'])
            ->where('is_active', '=', true)
            ->where('created_by_user_id', '=', $userId)
            ->orderByDesc('created_at')->paginate($perPage);
    }

    public function findById(string $id): array|Model|Collection|BaseModel|Event|_IH_BaseModel_C|_IH_Event_C|null
    {
        return $this->event->find($id);
    }

    public function update(string $id, array $data): array|Model|Collection|BaseModel|Event|_IH_BaseModel_C|_IH_Event_C|null
    {
        $data = array_merge($data, [
            'updated_by_user_id' => auth()->user()->id,
            'event_status_id' => EventStatusHelper::AwaitingReConfirmation,
            'show_ticket_count' => ($data['show_ticket_count'] ?? null) == 'on',
            'free_entrance' => ($data['free_entrance'] ?? null) == 'on',
        ]);

        foreach ($data['event_schedules'] as $k => &$v) {
            if (!is_string($k) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $k) !== 1)) {
                $k = Uuid::uuid4();
            }
            $v['id'] = $k;
        }

        $event = $this->event::find($id);
        $event->update($data);
        $event->event_schedules()->sync($data['event_schedules']);
        $event->save();

        return $event;
    }

    public function updateViewCount(string $id): array|Model|Collection|BaseModel|Event|_IH_BaseModel_C|_IH_Event_C|null
    {
        $event = $this->event::find($id);
        $event->view_count++;
        $event->save();

        return $event;
    }

    public function incrementRegisteredUsers($id): array|Model|Collection|BaseModel|Event|_IH_BaseModel_C|_IH_Event_C|null
    {
        $event = $this->event::find($id);
        $event->registered_users++;
        $event->save();

        return $event;
    }
}
