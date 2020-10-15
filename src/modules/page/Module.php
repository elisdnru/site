<?php

namespace app\modules\page;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\page\models\Page;
use yii\caching\TagDependency;

class Module extends Base implements UrlProvider, SitemapProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Контент';
    }

    public function getName(): string
    {
        return 'Страницы';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Страницы', 'url' => ['/page/admin/page/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить страницу', 'url' => ['/page/admin/page/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications(): array
    {
        return [];
    }

    public static function rules(): array
    {
        return [
            'copyright' => 'page/default/copyright',
            'privacy' => 'page/default/privacy',
            ['class' => components\PageUrlRule::class, 'cache' => 3600 * 24],
        ];
    }

    public static function rulesPriority(): int
    {
        return -1;
    }

    public static function sitemap(): array
    {
        /** @psalm-var Page[] $pages */
        $pages = Page::find()->cache(0, new TagDependency(['tags' => ['page']]))
            ->andWhere(['system' => 0])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        return [
            new Group('Страницы', self::itemRecursive($pages, 0)),
            new Group('Страницы', [
                new Item(
                    '/copyright',
                    'Использование материалов',
                    null,
                    []
                ),
                new Item(
                    '/privacy',
                    'Политика конфиденциальности',
                    null,
                    []
                ),
            ]),
        ];
    }

    /**
     * @param Page[] $pages
     * @param int $parent
     * @return Item[]
     */
    private static function itemRecursive(array $pages, int $parent): array
    {
        $items = [];

        foreach ($pages as $page) {
            if ($page->parent_id === $parent) {
                $items[] = new Item(
                    $page->getUrl(),
                    $page->title,
                    $page->isIndexed() ? new Xml(Xml::WEEKLY, 0.5, null) : null,
                    self::itemRecursive($pages, $page->id)
                );
            }
        }

        return $items;
    }

    public static function sitemapPriority(): int
    {
        return 0;
    }
}
