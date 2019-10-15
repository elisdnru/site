<?php

namespace app\modules\comment;

use app\components\GroupUrlRule;
use app\modules\comment\models\Comment;
use app\components\module\Module as Base;

class Module extends Base
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getName(): string
    {
        return 'Комментарии';
    }

    public static function notifications(): array
    {
        $comments = Comment::model()->count([
            'condition' => 'moder=0',
        ]);

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
}
