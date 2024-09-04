<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\Event;
use App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()->orderByDesc('created_at')->get();

        return view('admin.event.index', compact('events'));
    }

    public function confirm(Event $event)
    {
        $event->event_status_id = EventStatusHelper::Confirmed;
        $event->save();

        return redirect()->back();
    }

    public function cancel(Event $event)
    {
        $event->event_status_id = EventStatusHelper::Canceled;
        $event->save();

        return redirect()->back();
    }
}
