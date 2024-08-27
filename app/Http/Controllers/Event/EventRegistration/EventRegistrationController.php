<?php

namespace App\Http\Controllers\Event\EventRegistration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evens\EventNewsletterRequest;
use App\Http\Requests\Evens\EventRegistration\StoreEventRegistrationRequest;
use App\Jobs\SendNewsLetterJob;
use App\Models\Event\Event;
use App\Models\Event\EventRegistration\EventRegistration;
use App\Repositories\Event\EventRegistration\EventRegistrationRepositoryContract;
use App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper;
use App\Services\Common\Traits\CreateUserOrAdmin;
use App\Services\Event\EventRegistration\EventRegistrationServiceContract;

class EventRegistrationController extends Controller
{
    use CreateUserOrAdmin;

    private EventRegistrationServiceContract $eventRegistrationService;
    private EventRegistrationRepositoryContract $eventRegistrationRepository;

    public function __construct(EventRegistrationServiceContract $eventRegistrationService,
                                EventRegistrationRepositoryContract $eventRegistrationRepository)
    {
        $this->eventRegistrationService = $eventRegistrationService;
        $this->eventRegistrationRepository = $eventRegistrationRepository;
    }

    public function store(StoreEventRegistrationRequest $request, Event $event)
    {
        $this->eventRegistrationService->create($event->id, $request->validated(), $event->is_auto_confirm);

        return redirect()->back();
    }

    public function newsletter(EventNewsletterRequest $request, Event $event)
    {
        self::validateEvent($event);

        $eventConfirmRegistrations = EventRegistration::query()
            ->with('user')
            ->where('event_id', $event->id)
            ->where('event_registration_status_id', EventRegistrationStatusHelper::Confirmed->value)
            ->get();

        $registeredUsers = [];
        foreach ($eventConfirmRegistrations as $item) {
            $registeredUsers[] = $item->user;
        }

        SendNewsLetterJob::dispatch($registeredUsers, $event->title . "\n" . $request->get('message'));

        session()->flash('flash_message', 'Рассылка успешно отправлено пользователям');

        return redirect()->back();
    }

    public function confirm(EventRegistration $eventRegistration)
    {
        self::validateEvent($eventRegistration->event);
        $this->eventRegistrationRepository->confirm($eventRegistration->id);

        return redirect()->back();
    }

    public function cancel(EventRegistration $eventRegistration)
    {
        self::validateEvent($eventRegistration->event);
        $this->eventRegistrationRepository->cancel($eventRegistration->id);

        return redirect()->back();
    }
}
