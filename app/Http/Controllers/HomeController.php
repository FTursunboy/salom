<?php

namespace App\Http\Controllers;

use App\Models\Event\Event;
use App\Models\Event\EventCategory\EventCategory;
use App\Models\Event\EventSchedule\EventSchedule;
use App\Models\Locations\City\City;
use App\Repositories\Event\EventCategory\EventCategoryRepositoryContract;
use App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private EventCategoryRepositoryContract $eventCategoryRepository;

    public function __construct(EventCategoryRepositoryContract $eventCategoryRepository)
    {
        $this->eventCategoryRepository = $eventCategoryRepository;
    }

    public function index(Request $request)
    {
        $currentCityId = \Cache::get('currentCityId');

        $countDaysEvents = 50;
        $weeks = ['ВС', 'ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ'];
        $monthWithSuffixes = [
            'января', 'февраля', 'марта',
            'апреля', 'мая', 'июня',
            'июля', 'августа', 'сентября',
            'октября', 'ноября', 'декабря'
        ];
        $months = [
            'январь', 'февраль', 'март',
            'апрель', 'май', 'июнь',
            'июль', 'август', 'сентябрь',
            'октябрь', 'ноябрь', 'декабрь'
        ];

        $requestDate = $request->get('date');
        if (empty($requestDate) || $requestDate < Carbon::now()->format('Y-m-d')) {
            $requestDate = Carbon::now()->format('Y-m-d');
        }

        $eventDays = EventSchedule::query()
            ->select(['start_date', 'end_date'])
            ->join('events', 'events.id', '=', 'event_schedules.event_id')
            ->where(function ($query) use ($countDaysEvents) {
                $query->where('start_date', '>=', Carbon::now()->toDateString())
                    ->orWhere('end_date', '<=', Carbon::now()
                        ->addDays($countDaysEvents)->toDateString());
            })
            ->where('is_active', '=', true)
            ->where('event_status_id', '=', EventStatusHelper::Confirmed->value)
            ->distinct()->get();

        $eventDaysActive = [];
        foreach ($eventDays as $item) {
            $day = $item->start_date;
            while ($day <= $item->end_date) {
                $eventDaysActive[$day->toDateString()] = true;
                $day->addDay();
            }
        }

        $eventSchedules = EventSchedule::query()
            ->where('start_date', '<=', $requestDate)
            ->where('end_date', '>=', $requestDate)
            ->get();

        $events = Event::query()
            ->where('is_active', '=', true)
            ->where('event_status_id', '=', EventStatusHelper::Confirmed)
            ->whereIn('id', $eventSchedules->pluck('event_id'))

            ->orderByDesc('events.created_at')
            ->get();

//        dd($events);

        $eventCategories = EventCategory::query()->whereIn('id', $events->pluck('event_category_id'))->get();

        foreach ($eventCategories as &$eventCategory) {
            $eventCategory->setRelation('custom_events', $events->where('event_category_id', $eventCategory->id));
        }

        return view('home.index', compact('weeks', 'eventCategories', 'requestDate',
            'monthWithSuffixes', 'months', 'countDaysEvents', 'eventDaysActive'));
    }
}
