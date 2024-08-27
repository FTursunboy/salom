<?php

namespace App\Models;

use App\Services\Common\Traits\UuidModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\BaseAuthenticatable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseAuthenticatable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseAuthenticatable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseAuthenticatable query()
 * @mixin \Eloquent
 */
class BaseAuthenticatable extends Authenticatable
{
    use UuidModel;

    public $incrementing = false;
}
