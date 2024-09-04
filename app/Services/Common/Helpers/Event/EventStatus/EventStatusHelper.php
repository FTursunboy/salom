<?php

namespace App\Services\Common\Helpers\Event\EventStatus;

enum EventStatusHelper: string
{
    case AwaitingConfirmation = '02bd099c-4b4f-11ee-8561-00ff535e960d';
    case Confirmed = '0a07a6de-4b4f-11ee-8561-00ff535e960d';
    case Canceled = '0cdbf663-4b4f-11ee-8561-00ff535e960d';
    case AwaitingReConfirmation = '10863504-4b4f-11ee-8561-00ff535e960d';
    case InArchive = '14531c68-4b4f-11ee-8561-00ff535e960d';
}
