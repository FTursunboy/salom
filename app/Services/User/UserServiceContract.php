<?php

namespace App\Services\User;

use App\Models\User;

interface UserServiceContract
{
    public function checkConfirmAt(User $user);

    public function getRetrySendSmsAt(User $user);
    public function checkConfirmSmsCode(User $user);

    public function updateSmsCodeForVerification(User $user);

    public function tryConfirmSmsCode(User $user, string $smsCode);

}
