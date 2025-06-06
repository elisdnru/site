<?php

declare(strict_types=1);

namespace app\modules\blog;

use app\components\module\admin\AdminMenuProvider;
use app\components\module\admin\AdminNotificationsProvider;
use app\components\module\routes\RoutesProvider;
use app\components\module\sitemap\Group;
use app\components\module\sitemap\Item;
use app\components\module\sitemap\SitemapProvider;
use app\components\module\sitemap\Xml;
use app\modules\blog\models\Post;
use app\modules\comment\models\Comment;
use Override;
use yii\base\Module as Base;
use yii\caching\TagDependency;
use yii\helpers\Url;
use yii\web\GroupUrlRule;

final class Module extends Base implements RoutesProvider, AdminMenuProvider, AdminNotificationsProvider, SitemapProvider
{
    #[Override]
    public function adminGroup(): string
    {
        return 'Блог';
    }

    #[Override]
    public function adminName(): string
    {
        return 'Блог';
    }

    #[Override]
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

    #[Override]
    public static function adminNotifications(): array
    {
        $comments = Comment::find()->type(Post::class)->unread()->count();

        return [
            [
                'label' => 'Комментарии к записям' . ($comments ? ' (' . $comments . ')' : ''),
                'url' => ['/blog/admin/comment/index'],
                'icon' => 'comments.png',
            ],
        ];
    }

    #[Override]
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
                    '<id:[\d]+>/<slug:.+>' => 'post/show',
                    '<id:[\d]+>' => 'post/show',
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
        return 98;
    }

    #[Override]
    public static function sitemap(): array
    {
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
                ),
            ]),

            new Group('Записи в блоге', array_map(static fn (Post $post): Item => new Item(
                Url::to(['/blog/post/show', 'id' => $post->id, 'slug' => $post->slug]),
                $post->title,
                new Xml(Xml::WEEKLY, 0.5, null),
                []
            ), $posts)),
        ];
    }

    #[Override]
    public static function sitemapPriority(): int
    {
        return 80;
    }
}
