<?php

namespace Database\Seeders;

use App\Models\PopularPlace\PopularPlace;

class PopularPlaceSeeder extends BaseSeeder
{
    public function run(): void
    {
        $items = [
            [
                'id' => 'a57b9e86-481c-11ee-ae64-00ff535e960d',
                'name' => 'Кафе Чатр (ул. Н. Хусрав, 11)',
                'latitude' => '38.605713',
                'longitude' => '68.788758',
            ],
            [
                'id' => 'b700465f-481c-11ee-ae64-00ff535e960d',
                'name' => 'Mazza Cafe (ул. Ф. Ниёзи, 51)',
                'latitude' => '38.580593',
                'longitude' => '68.793466',
            ],
            [
                'id' => 'ba45c5b7-481c-11ee-ae64-00ff535e960d',
                'name' => 'Moose (у. Бохтар, 2) ',
                'latitude' => '38.572442',
                'longitude' => '68.789149',
            ],
            [
                'id' => 'c255a443-481c-11ee-ae64-00ff535e960d',
                'name' => 'Moose (пр. Рудаки, 66)',
                'latitude' => '38.579078',
                'longitude' => '68.787810',
            ],
            [
                'id' => 'c5b9d260-481c-11ee-ae64-00ff535e960d',
                'name' => 'Moose (пр. Рудаки, 32/1)',
                'latitude' => '38.568810',
                'longitude' => '68.792634',
            ],
            [
                'id' => 'ccc88853-481c-11ee-ae64-00ff535e960d',
                'name' => 'Moose (ул. С. Айни 55)',
                'latitude' => '38.563372',
                'longitude' => '68.808579',
            ],
            [
                'id' => 'd1874803-481c-11ee-ae64-00ff535e960d',
                'name' => 'Moose (ул. Н. Махсум, 72/2)',
                'latitude' => '38.584222',
                'longitude' => '68.746422',
            ],
            [
                'id' => 'd4b3150f-481c-11ee-ae64-00ff535e960d',
                'name' => 'Тартин (пр. Рудаки, 30)',
                'latitude' => '38.568346',
                'longitude' => '68.793071',
            ],
            [
                'id' => 'd823a8d1-481c-11ee-ae64-00ff535e960d',
                'name' => 'Тартин (ул. Хусейнзода, 20)',
                'latitude' => '38.568923',
                'longitude' => '68.789169',
            ],
            [
                'id' => 'de5ebe54-481c-11ee-ae64-00ff535e960d',
                'name' => 'Parking (ул. Шохтемур, 42)',
                'latitude' => '38.579090',
                'longitude' => '68.790923',
            ],
            [
                'id' => 'e25ab302-481c-11ee-ae64-00ff535e960d',
                'name' => 'Sim-sim (ул. Н. Хувайдуллоев, 2)',
                'latitude' => '38.563118',
                'longitude' => '68.767571',
            ],
            [
                'id' => 'e5e4cd73-481c-11ee-ae64-00ff535e960d',
                'name' => 'Burger J (ул. Шохтемур, 42)',
                'latitude' => '38.579085',
                'longitude' => '68.790756',
            ],
            [
                'id' => 'e97e4b55-481c-11ee-ae64-00ff535e960d',
                'name' => 'Алиф Академия (пр. И. Сомони, 3/2)',
                'latitude' => '38.582746,',
                'longitude' => '68.783325',
            ],
            [
                'id' => 'ec52f84a-481c-11ee-ae64-00ff535e960d',
                'name' => 'Илмхона (ул. Шохтемур, 42)',
                'latitude' => '38.579107',
                'longitude' => '68.790611',
            ],
            [
                'id' => 'efc5f640-481c-11ee-ae64-00ff535e960d',
                'name' => 'TUT coworking (ул. М. Турсунзаде, 45)',
                'latitude' => '38.580629',
                'longitude' => '68.794018',
            ],
            [
                'id' => 'f3259859-481c-11ee-ae64-00ff535e960d',
                'name' => 'American Space Dushanbe(ул. Мирзо Турсунзаде, 45',
                'latitude' => '38.580621',
                'longitude' => '68.793992',
            ],
            [
                'id' => 'f71bbc59-481c-11ee-ae64-00ff535e960d',
                'name' => 'Национальная библиотека Таджикистана(ул. Техрон, 5)',
                'latitude' => '38.573292',
                'longitude' => '68.783629',
            ],
            [
                'id' => 'fb6465c1-481c-11ee-ae64-00ff535e960d',
                'name' => 'Культурный центр Бактрия (ул. Мирзо Турсунзаде, 12А)',
                'latitude' => '38.571361',
                'longitude' => '68.795793',
            ],
            [
                'id' => 'fea7752c-481c-11ee-ae64-00ff535e960d',
                'name' => 'Небо Душанбе (кинотеатр)',
                'latitude' => '38.580629',
                'longitude' => '68.794018',
            ],
            [
                'id' => '0234fe98-481d-11ee-ae64-00ff535e960d',
                'name' => 'Bavaria House (ул. Шириншо Шотемура, 60)',
                'latitude' => '38.579469',
                'longitude' => '68.801850',
            ],
            [
                'id' => '060662ba-481d-11ee-ae64-00ff535e960d',
                'name' => 'CAF(ул. Шарифджона Хусейнзаде, 28)',
                'latitude' => '38.570586',
                'longitude' => '68.792469',
            ],
        ];

        foreach ($items as $item) {
            try {
                PopularPlace::create($item);
            }
            catch (\Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
        }
    }
}
