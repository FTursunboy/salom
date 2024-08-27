<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Event\EventRegistration\EventRegistration;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = EventRegistration::query()
            ->with(['event', 'event_registration_status'])
            ->where('user_id', '=', auth()->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return view('profile.tickets.index', compact('tickets'));
    }
}
