<?php

namespace App\Services\Common\Traits;

use App\Models\Event\Event;

trait CreateUserOrAdmin
{
    protected static function validateEvent(Event $event): void
    {
        if (empty(auth()->user()) || ($event->created_by_user_id !=
                auth()->user()->id && !auth()->user()->is_admin)) {
            abort(403);
        }
    }
}
