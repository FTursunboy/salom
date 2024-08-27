<?php

namespace Database\Seeders;

use App\Models\Event\EventRegistrationStatus\EventRegistrationStatus;
use App\Services\Common\Helpers\Event\EventRegistrationStatus\EventRegistrationStatusHelper;

class EventRegistrationStatusSeeder extends BaseSeeder
{
    public function run(): void
    {
        $items = [
            [
                'id' => EventRegistrationStatusHelper::AwaitingConfirmation,
                'name' => 'Ожидание подтверждения',
            ],
            [
                'id' => EventRegistrationStatusHelper::Canceled,
                'name' => 'Отменен',
            ],
            [
                'id' => EventRegistrationStatusHelper::Confirmed,
                'name' => 'Подтверждён',
            ],
        ];

        foreach ($items as $item)
        {
            try {
                EventRegistrationStatus::create($item);
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }
    }
}
