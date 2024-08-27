<?php

namespace App\Models\Event\EventRegistration;

use App\Models\BaseModel;
use App\Models\Event\Event;
use App\Models\Event\EventRegistrationStatus\EventRegistrationStatus;
use App\Models\Event\EventSchedule\EventSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Event\EventRegistration\EventRegistration
 *
 * @property int $id
 * @property string $user_id
 * @property string $event_id
 * @property string $event_schedule_id
 * @property string $event_registration_status_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereEventRegistrationStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereEventScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereUserId($value)
 * @property-read Event $event
 * @property-read EventRegistrationStatus $event_registration_status
 * @property-read EventSchedule $event_schedule
 * @property-read User $user
 * @property string|null $additional_fields_json
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistration whereAdditionalFieldsJson($value)
 * @mixin \Eloquent
 */
class EventRegistration extends BaseModel
{
    protected $fillable = [
        'user_id',
        'event_id',
        'event_schedule_id',
        'event_registration_status_id',
        'message',
        'additional_fields_json',
    ];

    protected $casts = [
        'additional_fields_json' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function event_schedule(): BelongsTo
    {
        return $this->belongsTo(EventSchedule::class);
    }

    public function event_registration_status(): BelongsTo
    {
        return $this->belongsTo(EventRegistrationStatus::class);
    }
}
