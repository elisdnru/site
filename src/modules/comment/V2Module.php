<?php

namespace app\modules\comment;

use app\components\module\routes\UrlProvider;
use app\modules\comment\models\Comment;
use app\components\module\Module as Base;
use yii\web\GroupUrlRule;

class V2Module extends Base implements UrlProvider
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

    public static function rules(): array
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

    public static function rulesPriority(): int
    {
        return 0;
    }
}
