<?php

namespace app\modules\blog;

use app\components\module\Module as Base;
use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\blog\models\Comment;
use app\modules\blog\models\Post;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\GroupUrlRule;

class Module extends Base implements RoutesProvider, SitemapProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Блог';
    }

    public function getName(): string
    {
        return 'Блог';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Категории', 'url' => ['/blog/admin/category/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Группы', 'url' => ['/blog/admin/group/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Метки', 'url' => ['/blog/admin/tag/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Записи', 'url' => ['/blog/admin/post/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications(): array
    {
        $comments = Comment::find()->unread()->count();

        return [
            ['label' => 'Комментарии к записям' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/blog/admin/comment/index'], 'icon' => 'comments.png'],
        ];
    }

    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'blog',
                'rules' => [
                    'feed' => 'feed/index',
                    'search' => 'default/search',
                    'tag/<tag:[\w-]+>/page-<page:\d+>' => 'default/tag',
                    'tag/<tag:[\w-]+>' => 'default/tag',
                    'date/<date:[\w-]+>/page-<page:\d+>' => 'default/date',
                    'date/<date:[\w-]+>' => 'default/date',
                    '<id:[\d]+>/<alias:.+>' => 'post/show',
                    '<id:[\d]+>' => 'post/show',
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
        return 98;
    }

    public static function sitemap(): array
    {
        /** @psalm-var Post[] $posts */
        $posts = Post::find()->published()
            ->cache(0, new TagDependency(['tags' => ['blog']]))
            ->orderBy(['title' => SORT_ASC])
            ->all();

        return [
            new Group('Страницы', [
                new Item(
                    Url::to(['/blog/default/index']),
                    'Официальный блог',
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                )
            ]),

            new Group('Записи в блоге', array_map(static function (Post $post): Item {
                return new Item(
                    $post->getUrl(),
                    $post->title,
                    new Xml(Xml::WEEKLY, 0.5, null),
                    []
                );
            }, $posts))
        ];
    }

    public static function sitemapPriority(): int
    {
        return 80;
    }
}
