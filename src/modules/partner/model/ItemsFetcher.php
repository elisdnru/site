<?php

declare(strict_types=1);

namespace app\modules\partner\model;

class ItemsFetcher
{
    /**
     * @return Item[]
     */
    public function getAll(): array
    {
        return [
            new Item(
                title: 'Практикум Git & Composer',
                url: '/git-composer',
                price: 2400,
                firstPercent: 30,
                secondPercent: 5
            ),
            new Item(
                title: 'Интенсив Неделя ООП',
                url: '/oop-week',
                price: 5950,
                firstPercent: 30,
                secondPercent: 5
            ),
            new Item(
                title: 'Мастер-класс Kafka и RabbitMQ',
                url: '/blog/125/rabbitmq-master-class',
                price: 3450,
                firstPercent: 30,
                secondPercent: 5
            ),
            new Item(
                title: 'Мастер-класс Магазин на Yii2',
                url: '/yii2-shop',
                price: 9950,
                firstPercent: 30,
                secondPercent: 5
            ),
            new Item(
                title: 'Мастер-класс Сайт объявлений на Laravel',
                url: '/laravel-board',
                price: 8800,
                firstPercent: 30,
                secondPercent: 5
            ),
            new Item(
                title: 'Мастер-класс Разработка менеджера проектов',
                url: '/project-manager',
                price: 14000,
                firstPercent: 30,
                secondPercent: 5
            ),
        ];
    }
}
