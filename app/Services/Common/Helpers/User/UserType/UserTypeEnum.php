<?php

namespace App\Services\Common\Helpers\User\UserType;

enum UserTypeEnum: string
{
    case ParticipantId = '20c1da3a-4304-11ee-9288-00ff535e960d';
    case OrganizerId = '267777f0-4304-11ee-9288-00ff535e960d';

    case ParticipantCode = 'participant';
    case OrganizerCode = 'organizer';
}
