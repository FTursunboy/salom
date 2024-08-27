<?php

namespace App\Models\PopularPlace;

use App\Models\BaseModel;
use Eloquent as EloquentAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\PopularPlace\PopularPlace
 *
 * @property string $id
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|PopularPlace newModelQuery()
 * @method static Builder|PopularPlace newQuery()
 * @method static Builder|PopularPlace query()
 * @method static Builder|PopularPlace whereCreatedAt($value)
 * @method static Builder|PopularPlace whereId($value)
 * @method static Builder|PopularPlace whereIsActive($value)
 * @method static Builder|PopularPlace whereLatitude($value)
 * @method static Builder|PopularPlace whereLongitude($value)
 * @method static Builder|PopularPlace whereName($value)
 * @method static Builder|PopularPlace whereUpdatedAt($value)
 * @mixin EloquentAlias
 */
class PopularPlace extends BaseModel
{
    protected $fillable = [
        'id',
        'name',
        'longitude',
        'latitude',
        'is_active',
    ];
}
