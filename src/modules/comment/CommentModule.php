<?php

class CommentModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.comment.components.*',
            'application.modules.comment.models.*',
            'blog.models.BlogComment'
        ]);
    }

    public function getName()
    {
        return 'Комментарии';
    }

    public static function notifications()
    {
        Yii::import('application.modules.comment.models.Comment');

        $comments = Comment::model()->count([
            'condition' => 'moder=0',
        ]);

        return [
            ['label' => 'Все комментарии' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/comment/commentAdmin/index'], 'icon' => 'comments.png'],
        ];
    }

    public static function rules()
    {
        return [
            'comment/update/<id:\d+>' => 'comment/comment/update',
            'comment/like/<id:\d+>' => 'comment/ajax/like',
            'comment/hide/<id:\d+>' => 'comment/ajax/hide',
            'comment/delete/<id:\d+>' => 'comment/ajax/delete',
        ];
    }
}
