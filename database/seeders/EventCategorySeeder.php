<?php

namespace Database\Seeders;

use App\Models\Event\EventCategory\EventCategory;

class EventCategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        $items = [
            [
                'id' => '3d0c8857-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Кино',
            ],
            [
                'id' => '406ce768-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Концерты',
            ],
            [
                'id' => '43983226-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Вечеринки',
            ],
            [
                'id' => '48fb69f2-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Фестивали',
            ],
            [
                'id' => '50e0c95f-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Выставки',
            ],
            [
                'id' => '54d1e01a-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Ярмарки',
            ],
            [
                'id' => '57bc8493-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Театр',
            ],
            [
                'id' => '5b9c891d-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Встречи',
            ],
            [
                'id' => '6044e207-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Благотворительность',
            ],
            [
                'id' => '648f855c-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Праздники',
            ],
            [
                'id' => '6778c395-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Бизнес',
            ],
            [
                'id' => '6aef2d4f-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Образование',
            ],
            [
                'id' => '6fc9faeb-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Шоппинг',
            ],
            [
                'id' => '72caff6e-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Мода и стиль',
            ],
            [
                'id' => '761c2a75-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Конкурсы',
            ],
            [
                'id' => '793965ea-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Детям',
            ],
            [
                'id' => '7bff00e7-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Квесты',
            ],
            [
                'id' => '7f061790-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Молодежные',
            ],
            [
                'id' => '823c70e5-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Откровение',
            ],
            [
                'id' => '863dd76f-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Развлечения',
            ],
            [
                'id' => '8a2e39ea-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Бесплатные события',
            ],
            [
                'id' => '8cd720f5-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Спорт',
            ],
            [
                'id' => '8f4ff471-47f3-11ee-ae64-00ff535e960d',
                'name' => 'Туризм',
            ],
        ];

        foreach ($items as $item) {
            try {
                EventCategory::create($item);
            } catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }
    }
}
