<?php

class CommentModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.comment.components.*',
            'application.modules.comment.models.*',
            'application.modules.new.models.*',
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
            'comment/update/<id:\d+>'=>'comment/comment/update',
            'comment/like/<id:\d+>'=>'comment/ajax/like',
            'comment/hide/<id:\d+>'=>'comment/ajax/hide',
            'comment/delete/<id:\d+>'=>'comment/ajax/delete',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'COMMENT.SEND_REPLY_EMAILS',
                'label'=>'Уведомлять пользователей об ответе на их комментарий',
                'value'=>'1',
                'type'=>'checkbox',
                'default'=>'1',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'COMMENT.SEND_REPLY_EMAILS',
        ));

        return parent::uninstall();
    }
}