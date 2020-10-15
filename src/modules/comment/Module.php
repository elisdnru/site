<?php

namespace app\modules\comment;

use app\components\module\routes\RoutesProvider;
use app\modules\comment\models\Comment;
use app\components\module\Module as Base;
use yii\web\GroupUrlRule;

class Module extends Base implements RoutesProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Комментарии';
    }

    public static function adminMenu(): array
    {
        return [];
    }

    public static function notifications(): array
    {
        $comments = Comment::find()->unread()->count();

        return [
            ['label' => 'Все комментарии' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/comment/admin/comment/index'], 'icon' => 'comments.png'],
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
