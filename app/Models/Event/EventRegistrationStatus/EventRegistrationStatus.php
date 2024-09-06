<?php

namespace App\Models\Event\EventRegistrationStatus;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event\EventRegistrationStatus\EventRegistrationStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventRegistrationStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventRegistrationStatus extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
    ];
}
