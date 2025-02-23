<?php

declare(strict_types=1);

namespace app\modules\portfolio;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\portfolio\models\Work;
use Override;
use yii\base\Module as Base;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\GroupUrlRule;

final class Module extends Base implements RoutesProvider, AdminMenuProvider, SitemapProvider
{
    #[Override]
    public function adminGroup(): string
    {
        return 'Контент';
    }

    #[Override]
    public function adminName(): string
    {
        return 'Портфолио';
    }

    #[Override]
    public static function adminMenu(): array
    {
        return [
            ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create'], 'icon' => 'add.png'],
        ];
    }

    #[Override]
    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'portfolio',
                'rules' => [
                    '<category:[\w_\/-]+>/<id:[\d]+>/<slug:.+>' => 'work/show',
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

    #[Override]
    public static function routesPriority(): int
    {
        return 0;
    }

    #[Override]
    public static function sitemap(): array
    {
        /**
         * @var Work[] $works
         */
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
                ),
            ]),
            new Group('Портфолио', array_map(static fn (Work $work): Item => new Item(
                Url::to([
                    '/portfolio/work/show',
                    'category' => $work->category->getPath(),
                    'id' => $work->id,
                    'slug' => $work->slug,
                ]),
                $work->title,
                null,
                []
            ), $works)),
        ];
    }

    #[Override]
    public static function sitemapPriority(): int
    {
        return 70;
    }
}
