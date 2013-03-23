<?php

class CommentModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'comment.components.*',
            'comment.models.*',
            'new.models.*',
        ));

        if (Yii::app()->moduleManager->installed('blog'))
            $this->setImport(array('blog.models.BlogComment'));
    }

    public function getName()
    {
        return 'Комментарии';
    }

    public static function notifications()
    {
        Yii::import('application.modules.comment.models.Comment');

        $comments = Comment::model()->count(array(
            'condition'=>'moder=0',
        ));

        return array(
            array('label'=>'Все комментарии' . ($comments ?  ' (' . $comments . ')' : ''), 'url'=>array('/comment/commentAdmin/index'), 'icon'=>'comments.png'),
        );
    }

    public static function rules()
    {
        return array(
            'comment/like/<id:\d+>'=>'comment/ajax/like',
            'comment/hide/<id:\d+>'=>'comment/ajax/hide',
            'comment/delete/<id:\d+>'=>'comment/ajax/delete',
        );
    }
}
