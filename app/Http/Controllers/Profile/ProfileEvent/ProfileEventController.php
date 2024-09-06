<?php

namespace App\Http\Controllers\Profile\ProfileEvent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evens\StoreEventRequest;
use App\Http\Requests\Evens\UpdateEventRequest;
use App\Models\Event\Event;
use App\Repositories\Event\EventCategory\EventCategoryRepositoryContract;
use App\Repositories\Event\EventRegistration\EventRegistrationRepositoryContract;
use App\Repositories\Event\EventRepositoryContract;
use App\Repositories\PopularPlace\PopularPlaceRepositoryContract;
use App\Services\Common\Helpers\Image\ImageFolderHelper;
use App\Services\Common\Image\ImageServiceContract;
use App\Services\Common\Traits\CreateUserOrAdmin;
use App\Services\Profile\ProfileEvent\ProfileEventContract;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ProfileEventController extends Controller
{
    use CreateUserOrAdmin;

    private ImageServiceContract $imageService;
    private EventRepositoryContract $eventRepository;
    private ProfileEventContract $profileEventService;
    private PopularPlaceRepositoryContract $popularPlaceRepository;
    private EventCategoryRepositoryContract $eventCategoryRepository;
    private EventRegistrationRepositoryContract $eventRegistrationRepository;

    public function __construct(ImageServiceContract $imageService,
                                EventRepositoryContract $eventRepository,
                                ProfileEventContract $profileEventService,
                                PopularPlaceRepositoryContract $popularPlaceRepository,
                                EventCategoryRepositoryContract $eventCategoryRepository,
                                EventRegistrationRepositoryContract $eventRegistrationRepository)
    {
        $this->imageService = $imageService;
        $this->eventRepository = $eventRepository;
        $this->profileEventService = $profileEventService;
        $this->popularPlaceRepository = $popularPlaceRepository;
        $this->eventCategoryRepository = $eventCategoryRepository;
        $this->eventRegistrationRepository = $eventRegistrationRepository;
    }

    public function index()
    {
        $events = $this->eventRepository->paginateByUserId(auth()->user()->id);

        return view('profile.events.index', compact('events'));
    }

    public function create()
    {
        $eventCategories = $this->eventCategoryRepository->listAll();
        $popularPlaces = $this->popularPlaceRepository->all();

        return view('profile.events.create', compact('eventCategories', 'popularPlaces'));
    }

    public function store(StoreEventRequest $request)
    {
        $this->profileEventService->create($request->validated());

        return redirect()->route('profile.events.index');
    }

    public function edit(Event $event)
    {
        $eventCategories = $this->eventCategoryRepository->listAll();
        $popularPlaces = $this->popularPlaceRepository->all();

        return view('profile.events.edit', compact('event', 'eventCategories', 'popularPlaces'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        self::validateEvent($event);

        $this->profileEventService->update($event->id, $request->validated());

        return redirect()->route('profile.events.index');
    }

    public function destroy(Event $event)
    {
        self::validateEvent($event);

        $this->profileEventService->destroy($event->id);

        return redirect()->route('profile.events.index');
    }

    public function analytics(Event $event)
    {
        self::validateEvent($event);

        $schedules = $event->schedules->groupBy('start_date');
        $this->eventRepository->updateViewCount($event->id);

        $registrations = $this->eventRegistrationRepository->getAllRegistrations($event->id);

//        dd($registrations->first()->additional_fields_json);

        return view('profile.events.show_with_analytics', compact('event', 'schedules', 'registrations'));
    }

    public function uploadImage(Request $request)
    {
        $name = Uuid::uuid4();
        $data = $request->get('image');

        $imageArray1 = explode(";", $data);
        $imageArray2 = explode(",", $imageArray1[1]);

        $image = base64_decode($imageArray2[1]);

        $this->imageService->saveImageBase64WithParam(public_path(ImageFolderHelper::TEMP_IMAGES_PATH), $image, 720, 300, $name);

        return $name . '.jpg';
    }
}
