<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Common\Helpers\Helper;
use Carbon\Carbon;

class UserService implements UserServiceContract
{
    private const smsCodeConfirmTryCount = 5;
    private const smsCodeRetrySendAt = 15;
    private const smsCodeConfirmAt = 5;

    public function updateSmsCodeForVerification(User $user): void
    {
        $user->sms_code = Helper::generateSmsCode();
        $user->sms_code_sent_at = Carbon::now();
        $user->sms_code_sent_count++;
        $user->sms_confirm_try_count = null;
        $user->sms_confirm_try_at = null;

        $user->save();
    }

    public function getRetrySendSmsAt(User $user)
    {
        $now = Carbon::now();

        if ($now < $user->sms_confirm_try_at->addMinutes($this::smsCodeRetrySendAt * $user->sms_code_sent_count) &&
            $user->sms_confirm_try_count >= $this::smsCodeConfirmTryCount) {

            $diff = $user->sms_confirm_try_at->addMinutes($this::smsCodeRetrySendAt * $user->sms_code_sent_count)->diff($now);

            if ($diff->i == 0) {
                return $diff->format('%s секунд');
            }

            return $diff->format('%i минут и %s секунд');
        }

        return null;
    }

    public function checkConfirmSmsCode(User $user): bool
    {
        return $user->sms_confirm_try_count < $this::smsCodeConfirmTryCount ||
            $user->sms_confirm_try_at == null ||
            $user->sms_confirm_try_at->addMinutes($this::smsCodeRetrySendAt * $user->sms_code_sent_count) < Carbon::now();
    }

    public function tryConfirmSmsCode(User $user, string $smsCode): bool
    {
        if ($user->checkSmsCode($smsCode) && $user->sms_confirm_try_count < $this::smsCodeConfirmTryCount) {
            return true;
        }

        $user->sms_confirm_try_count++;
        $user->sms_confirm_try_at = Carbon::now();
        $user->save();

        return false;
    }

    public function checkConfirmAt(User $user): bool
    {
        return $user->sms_code_sent_at->addMinutes($this::smsCodeConfirmAt) > Carbon::now();
    }
}
