<?php

namespace Database\Seeders;

use App\Models\UserType;
use App\Services\Common\Helpers\User\UserType\UserTypeEnum;

class UserTypeSeeder extends BaseSeeder
{
    public function run(): void
    {
        $items = [
            [
                'id' => UserTypeEnum::ParticipantId,
                'code' => UserTypeEnum::ParticipantCode,
                'name' => 'Участник',
            ],
            [
                'id' => UserTypeEnum::OrganizerId,
                'code' => UserTypeEnum::OrganizerCode,
                'name' => 'Организатор',
            ],
        ];

        foreach ($items as $item) {
            try {
                UserType::create($item);
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }
    }
}
