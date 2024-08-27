<?php

namespace App\Models\Event\EventCategory;

use App\Models\BaseModel;
use App\Models\Event\Event;
use App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper;
use Eloquent as EloquentAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event\EventCategory\EventCategory
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EventCategory newModelQuery()
 * @method static Builder|EventCategory newQuery()
 * @method static Builder|EventCategory query()
 * @method static Builder|EventCategory whereCreatedAt($value)
 * @method static Builder|EventCategory whereDescription($value)
 * @method static Builder|EventCategory whereId($value)
 * @method static Builder|EventCategory whereIsActive($value)
 * @method static Builder|EventCategory whereName($value)
 * @method static Builder|EventCategory whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Event> $last_events
 * @property-read int|null $last_events_count
 * @method static Builder|EventCategory eventsByDate()
 * @mixin EloquentAlias
 */
class EventCategory extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'is_active',
    ];

    public function last_events(): HasMany
    {
        return $this->hasMany(Event::class)
            ->where('is_active', '=', true)
            ->where('event_status_id', '=', EventStatusHelper::Confirmed)
            ->orderByDesc('events.created_at');
    }
}
