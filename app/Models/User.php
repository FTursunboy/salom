<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\VerifyPhoneNotification;
use App\Services\Common\Helpers\Helper;
use App\Services\Common\Helpers\Image\ImageFolderHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $user_type_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $phone_verified_at
 * @property string|null $sms_code
 * @property \Illuminate\Support\Carbon|null $sms_code_sent_at
 * @property int|null $sms_code_sent_count
 * @property int|null $sms_confirm_try_count
 * @property string|null $sms_confirm_try_at
 * @property string|null $sms_params_json
 * @property mixed $password
 * @property string|null $remember_token
 * @property string|null $photo
 * @property string|null $birth_date
 * @property int|null $gender
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsCodeSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsCodeSentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsConfirmTryAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsConfirmTryCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSmsParamsJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserTypeId($value)
 * @property-read string $full_name
 * @property string|null $background_image
 * @property-read string $phone_formatted
 * @property-read string $photo_path
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBackgroundImage($value)
 * @property-read string $background_image_path
 * @property int $is_admin
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @property int $is_verified
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsVerified($value)
 * @mixin \Eloquent
 */
class User extends BaseAuthenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type_id',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'phone',
        'password',
        'photo',
        'birth_date',
        'gender',
        'description',
        'telegram',
        'telegram_id',
        'telegram_username',
        'phone_verified_at',
        'sms_code',
        'sms_code_sent_at',
        'is_verified'
    ];

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'sms_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'sms_code_sent_at' => 'datetime',
        'sms_confirm_try_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasVerifiedPhone(): bool
    {
        return !is_null($this->phone_verified_at);
    }

    public function checkSmsCode($code): bool
    {
        return $code == $this->sms_code;
    }

    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'sms_code_sent_count' => 0,
            'sms_confirm_try_count' => 0,
            'phone_verified_at' => Carbon::now(),
        ])->save();
    }

    public function sendPhoneVerificationNotification(): void
    {
        $this->notify(new VerifyPhoneNotification());
    }

    public function routeNotificationForSmsTj(): string
    {
        return $this->phone;
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhoneFormattedAttribute(): string
    {
        return preg_replace('~.*(\d{3})(\d{2})(\d{3})(\d{4}).*~', '+$1 ($2) $3-$4', $this->phone);
    }

    public function getPhotoPathAttribute(): string
    {
        if ($this->photo) {
            return ImageFolderHelper::USERS_PHOTO_PATH . $this->photo;
        }

        return 'assets/img/default_user.jpg';
    }

    public function getBackgroundImagePathAttribute(): string
    {
        if ($this->background_image) {
            return ImageFolderHelper::USERS_PHOTO_PATH . $this->background_image;
        }

        return 'assets/img/default_background.jpg';
    }
}
