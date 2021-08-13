<?php

declare(strict_types=1);

namespace app\modules\comment;

use app\components\module\admin\AdminNotificationsProvider;
use app\components\module\routes\RoutesProvider;
use app\modules\comment\models\Comment;
use yii\base\Module as Base;
use yii\web\GroupUrlRule;

final class Module extends Base implements RoutesProvider, AdminNotificationsProvider
{
    public function adminGroup(): string
    {
        return '';
    }

    public function adminName(): string
    {
        return 'Комментарии';
    }

    public static function adminNotifications(): array
    {
        $comments = Comment::find()->unread()->count();

        return [
            [
                'label' => 'Все комментарии' . ($comments ? ' (' . $comments . ')' : ''),
                'url' => ['/comment/admin/comment/index'],
                'icon' => 'comments.png',
            ],
        ];
    }

    public static function routes(): array
    {
        return [
            [
                'class' => GroupUrlRule::class,
                'prefix' => 'comment',
                'rules' => [
                    'update/<id:\d+>' => 'comment/update',
                    'like/<id:\d+>' => 'ajax/like',
                    'hide/<id:\d+>' => 'ajax/hide',
                    'delete/<id:\d+>' => 'ajax/delete',
                ],
            ],
        ];
    }

    public static function routesPriority(): int
    {
        return 0;
    }
}
