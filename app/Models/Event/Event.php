<?php

namespace App\Models\Event;

use App\Models\BaseModel;
use App\Models\Event\EventCategory\EventCategory;
use App\Models\Event\EventRegistration\EventRegistration;
use App\Models\Event\EventSchedule\EventSchedule;
use App\Models\Event\EventStatus\EventStatus;
use App\Models\Locations\City\City;
use App\Models\Locations\Country\Country;
use App\Models\User;
use App\Services\Common\Helpers\Image\ImageFolderHelper;
use Eloquent as EloquentAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Vinkla\Hashids\Facades\Hashids;

/**
 * App\Models\Event\Event
 *
 * @property string $id
 * @property string $event_status_id
 * @property string $event_category_id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $photo
 * @property int|null $ticket_amount
 * @property int|null $ticket_count
 * @property int|null $show_ticket_count
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEventCategoryId($value)
 * @method static Builder|Event whereEventStatusId($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereIsActive($value)
 * @method static Builder|Event wherePhoto($value)
 * @method static Builder|Event whereShowTicketCount($value)
 * @method static Builder|Event whereText($value)
 * @method static Builder|Event whereTicketAmount($value)
 * @method static Builder|Event whereTicketCount($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @property string $event_type
 * @method static Builder|Event whereEventType($value)
 * @property int $registered_users
 * @method static Builder|Event whereRegisteredUsers($value)
 * @property int $view_count
 * @method static Builder|Event whereViewCount($value)
 * @property string $created_by_user_id
 * @method static Builder|Event whereCreatedByUserId($value)
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property-read EventStatus $event_status
 * @method static Builder|Event whereAddress($value)
 * @method static Builder|Event whereLatitude($value)
 * @method static Builder|Event whereLongitude($value)
 * @property-read string $photo_path
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventSchedule> $schedules
 * @property-read int|null $schedules_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventSchedule> $event_schedules
 * @property-read int|null $event_schedules_count
 * @property string|null $phones
 * @property string|null $sites
 * @method static Builder|Event wherePhones($value)
 * @method static Builder|Event whereSites($value)
 * @property string|null $country_id
 * @property string|null $city_id
 * @method static Builder|Event whereCityId($value)
 * @method static Builder|Event whereCountryId($value)
 * @property-read User $created_by
 * @property-read City|null $city
 * @property-read Country|null $country
 * @property-read mixed $sites_validated
 * @property-read EventCategory $event_category
 * @property-read string $thumb_photo_path
 * @property string|null $slug
 * @method static Builder|Event whereSlug($value)
 * @property-read mixed $end_date
 * @property-read mixed $start_date
 * @property int $id_inc
 * @property int $free_entrance
 * @method static Builder|Event whereFreeEntrance($value)
 * @method static Builder|Event whereIdInc($value)
 * @property string|null $organizer
 * @method static Builder|Event whereOrganizer($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventRegistration> $event_registered_users
 * @property-read int|null $event_registered_users_count
 * @property string|null $additional_fields_json
 * @method static Builder|Event whereAdditionalFieldsJson($value)
 * @property int $is_auto_confirm
 * @method static Builder|Event whereIsAutoConfirm($value)
 * @mixin EloquentAlias
 */
class Event extends BaseModel
{
    protected $fillable = [
        'event_status_id',
        'event_category_id',
        'created_by_user_id',
        'created_by_user_id',
        'country_id',
        'city_id',
        'title',
        'description',
        'text',
        'photo',
        'ticket_count',
        'ticket_amount',
        'address',
        'latitude',
        'longitude',
        'event_type',
        'show_ticket_count',
        'free_entrance',
        'phones',
        'sites',
        'organizer',
    ];

    protected $casts = [
        'phones' => 'array',
        'sites' => 'array',
        'additional_fields_json' => 'array',
    ];

    public function event_status(): BelongsTo
    {
        return $this->belongsTo(EventStatus::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(EventSchedule::class);
    }

    public function event_schedules(): BelongsToMany
    {
        return $this->belongsToMany(EventSchedule::class,
            'event_schedules', 'event_id', 'id');
    }

    public function event_category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function event_registered_users(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    protected function idInc(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Hashids::encode($value),
        );
    }

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return parent::resolveRouteBinding(Hashids::decode($value), $field);
    }

    public function getPhotoPathAttribute(): string
    {
        return ImageFolderHelper::TEMP_IMAGES_PATH . '/' . $this->photo;
    }

    public function getThumbPhotoPathAttribute(): string
    {
        return ImageFolderHelper::TEMP_IMAGES_PATH . '/thumb-' . $this->photo;
    }

    public function getSitesValidatedAttribute(): array
    {
        $items = [];

        foreach ($this->sites ?? [] as $site) {
            if ($site) {
                $url = $site;
                $title = $site;

                if(filter_var($site, FILTER_VALIDATE_EMAIL)) {
                    $url = 'mailto:' . $site;
                }
                else if(filter_var($site, FILTER_VALIDATE_DOMAIN)) {
                    if (!str_contains($url, 'http')) {
                        $url = "https://" . $url;
                    }
                    $url = str_replace('www.', '', $url);
                    $title = str_replace('www.', '', $title);

                    if (str_contains($title, 'instagram.com')) {
                        $title = str_replace('instagram.com/', '', $title);
                        $title = '<i class="fab fa-instagram"></i> ' . $title;
                    }
                    if (str_contains($title, 't.me')) {
                        $title = str_replace('t.me/', '', $title);
                        $title = '<i class="fab fa-telegram"></i> ' . $title;
                    }
                }

                $title = str_replace('https://', '', $title);
                $title = str_replace('http://', '', $title);

                $items[] = [
                    'url' => $url,
                    'title' => $title,
                ];
            }
        }

        return $items;
    }

    public function getStartDateAttribute()
    {
        return $this->schedules->min('start_date');
    }

    public function getEndDateAttribute()
    {
        return $this->schedules->max('end_date');
    }

    public function getRouteKeyName(): string
    {
        return 'id_inc';
    }
}
