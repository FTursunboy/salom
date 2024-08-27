<?php

namespace Database\Seeders;

use App\Models\Event\EventStatus\EventStatus;
use App\Services\Common\Helpers\Event\EventStatus\EventStatusHelper;

class EventStatusSeeder extends BaseSeeder
{
    public function run(): void
    {
        $items = [
            [
                'id' => EventStatusHelper::AwaitingConfirmation,
                'name' => 'Ожидание подтверждения',
            ],
            [
                'id' => EventStatusHelper::Canceled,
                'name' => 'Отменено',
            ],
            [
                'id' => EventStatusHelper::Confirmed,
                'name' => 'Подтвержденный',
            ],
            [
                'id' => EventStatusHelper::AwaitingReConfirmation,
                'name' => 'Ожидание повторного подтверждения',
            ],
            [
                'id' => EventStatusHelper::InArchive,
                'name' => 'В Архиве',
            ],

        ];

        foreach ($items as $item) {
            try {
                EventStatus::create($item);
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }
    }
}
