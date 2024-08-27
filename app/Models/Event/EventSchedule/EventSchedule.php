<?php

namespace App\Models\Event\EventSchedule;

use App\Models\BaseModel;
use Eloquent as EloquentAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event\EventSchedule\EventSchedule
 *
 * @property string $id
 * @property string $event_id
 * @property string $title
 * @property Carbon $start_date
 * @property mixed $start_time
 * @property Carbon $end_date
 * @property mixed $end_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EventSchedule newModelQuery()
 * @method static Builder|EventSchedule newQuery()
 * @method static Builder|EventSchedule query()
 * @method static Builder|EventSchedule whereCreatedAt($value)
 * @method static Builder|EventSchedule whereEndDate($value)
 * @method static Builder|EventSchedule whereEndTime($value)
 * @method static Builder|EventSchedule whereEventId($value)
 * @method static Builder|EventSchedule whereId($value)
 * @method static Builder|EventSchedule whereStartDate($value)
 * @method static Builder|EventSchedule whereStartTime($value)
 * @method static Builder|EventSchedule whereTitle($value)
 * @method static Builder|EventSchedule whereUpdatedAt($value)
 * @mixin EloquentAlias
 */
class EventSchedule extends BaseModel
{
    protected $fillable = [
        'event_id',
        'title',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'start_time' => 'datetime:H:i',
        'end_date' => 'datetime:Y-m-d',
        'end_time' => 'datetime:H:i',
    ];

    public function getTitleAttribute($value): string
    {
        return $value ?? '';
    }
}
