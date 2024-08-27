<?php

namespace App\Models\Event\EventStatus;

use App\Models\BaseModel;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event\EventStatus\EventStatus
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|EventStatus newModelQuery()
 * @method static Builder|EventStatus newQuery()
 * @method static Builder|EventStatus query()
 * @method static Builder|EventStatus whereCreatedAt($value)
 * @method static Builder|EventStatus whereDescription($value)
 * @method static Builder|EventStatus whereId($value)
 * @method static Builder|EventStatus whereIsActive($value)
 * @method static Builder|EventStatus whereName($value)
 * @method static Builder|EventStatus whereUpdatedAt($value)
 * @mixin Eloquent
 */
class EventStatus extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
