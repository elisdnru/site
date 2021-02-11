<?php

namespace app\modules\landing;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\landing\models\Landing;
use yii\base\Module as Base;
use yii\caching\TagDependency;

class Module extends Base implements RoutesProvider, AdminMenuProvider, SitemapProvider
{
    public function adminGroup(): string
    {
        return 'Контент';
    }

    public function adminName(): string
    {
        return 'Лендинги';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Лендинги', 'url' => ['/landing/admin/landing/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить лендинг', 'url' => ['/landing/admin/landing/create'], 'icon' => 'add.png'],
        ];
    }

    public static function routes(): array
    {
        return [
            'git-composer' => 'landing/default/git-composer',
            'oop-week' => 'landing/default/oop-week',
            'yii2-shop' => 'landing/default/yii2-shop',
            'laravel-board' => 'landing/default/laravel-board',
            ['class' => components\LandingUrlRule::class, 'cache' => 3600 * 24],
        ];
    }

    public static function routesPriority(): int
    {
        return -1;
    }

    public static function sitemap(): array
    {
        /** @psalm-var Landing[] $landings */
        $landings = Landing::find()->cache(0, new TagDependency(['tags' => ['landing']]))
            ->andWhere(['system' => 0])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        return [
            new Group('Продукты', [
                new Item(
                    '/git-composer',
                    'Git и Composer для начинающих',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
                new Item(
                    '/oop-week',
                    'Неделя ООП',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
                new Item(
                    '/yii2-shop',
                    'Мастер-класс Yii2 Shop',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
                new Item(
                    '/laravel-board',
                    'Мастер-класс Laravel',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                ),
            ]),
            new Group('Продукты', self::itemRecursive($landings, null)),
        ];
    }

    /**
     * @param Landing[] $landings
     * @param int|null $parent
     * @return Item[]
     */
    private static function itemRecursive(array $landings, ?int $parent): array
    {
        $items = [];

        foreach ($landings as $landing) {
            if ($landing->parent_id === $parent) {
                $items[] = new Item(
                    $landing->getUrl(),
                    $landing->title,
                    new Xml(Xml::WEEKLY, 0.5, null),
                    self::itemRecursive($landings, $landing->id)
                );
            }
        }

        return $items;
    }

    public static function sitemapPriority(): int
    {
        return 98;
    }
}
