<?php

namespace app\modules\portfolio;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\admin\AdminDashboardItem;
use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\portfolio\models\Work;
use yii\base\Module as Base;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\GroupUrlRule;

class Module extends Base implements AdminDashboardItem, RoutesProvider, AdminMenuProvider, SitemapProvider
{
    public function adminGroup(): string
    {
        return 'Контент';
    }

    public function adminName(): string
    {
        return 'Портфолио';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create'], 'icon' => 'add.png'],
        ];
    }

    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'portfolio',
                'rules' => [
                    '<category:[\w_\/-]+>/<id:[\d]+>/<alias:.+>' => 'work/show',
                    '<category:[\w_\/-]+>/<id:[\d]+>' => 'work/show',
                    '<id:[\d]+>' => 'work/show',
                    '<category:[\w_\/-]+>/page-<page:\d+>' => 'default/category',
                    'page-<page:\d+>' => 'default/index',
                    '<category:[\w_\/-]+>' => 'default/category',
                    '' => 'default/index',
                ],
            ],
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }

    public static function sitemap(): array
    {
        /** @psalm-var Work[] $works */
        $works = Work::find()->published()
            ->cache(0, new TagDependency(['tags' => 'portfolio']))
            ->orderBy(['title' => SORT_ASC])
            ->all();

        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/portfolio/default/index']),
                    'Портфолио',
                    new Xml(Xml::MONTHLY, 0.5, null),
                    []
                )
            ]),
            new Group('Портфолио', array_map(function (Work $work): Item {
                return new Item(
                    $work->getUrl(),
                    $work->title,
                    null,
                    []
                );
            }, $works))
        ];
    }

    public static function sitemapPriority(): int
    {
        return 70;
    }
}
