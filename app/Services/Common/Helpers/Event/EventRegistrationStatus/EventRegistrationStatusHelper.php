<?php

namespace App\Services\Common\Helpers\Event\EventRegistrationStatus;

enum EventRegistrationStatusHelper: string
{
    case AwaitingConfirmation = 'ac69b192-4e73-11ee-88f4-00ff535e960d';
    case Confirmed = 'b90c7b79-4e73-11ee-88f4-00ff535e960d';
    case Canceled = 'bc348eb2-4e73-11ee-88f4-00ff535e960d';
}
