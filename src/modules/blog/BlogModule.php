<?php

class BlogModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.blog.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Блог';
    }

    public function getName()
    {
        return 'Блог';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Категории', 'url'=>array('/blog/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Группы', 'url'=>array('/blog/groupAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Метки', 'url'=>array('/blog/tagAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Записи', 'url'=>array('/blog/postAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить запись', 'url'=>array('/blog/postAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function notifications()
    {
        if (!Yii::app()->moduleManager->active('comment'))
            return array();

        Yii::import('application.modules.blog.models.BlogPostComment');
        $comments = BlogPostComment::model()->lang(Yii::app()->language)->count(array(
            'condition'=>'moder=0 AND type=:type',
            'params'=>array(':type'=>BlogPostComment::TYPE_OF_COMMENT),
        ));

        return array(
            array('label'=>'Комментарии к записям' . ($comments ?  ' (' . $comments . ')' : ''), 'url'=>array('/blog/commentAdmin/index'), 'icon'=>'comments.png'),
        );
    }

    public static function rules()
    {
        return array(
            'blog/feed'=>'blog/feed/index',
            'blog/search'=>'blog/default/search',
            'blog/tag/<tag:[\w-]+>/page-<page:\d+>'=>'blog/default/tag',
            'blog/tag/<tag:[\w-]+>'=>'blog/default/tag',
            'blog/date/<date:[\w-]+>/page-<page:\d+>'=>'blog/default/date',
            'blog/date/<date:[\w-]+>'=>'blog/default/date',
            'blog/<id:[\d]+>/<alias:[\w_-]+>'=>'blog/post/show',
            'blog/<id:[\d]+>'=>'blog/post/show',
            'blog/<category:[\w_\/-]+>/page-<page:\d+>'=>'blog/default/category',
            'blog/page-<page:\d+>'=>'blog/default/index',
            'blog/<category:[\w_\/-]+>'=>'blog/default/category',
            'blog'=>'blog/default/index',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
             array(
                 'param'=>'BLOG.POSTS_PER_PAGE',
                 'label'=>'Записей на странице',
                 'value'=>'10',
                 'type'=>'string',
                 'default'=>'10',
             ),
             array(
                 'param'=>'BLOG.POSTS_PER_HOME',
                 'label'=>'Записей на главной странице',
                 'value'=>'10',
                 'type'=>'string',
                 'default'=>'10',
             ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
             'BLOG.POSTS_PER_PAGE',
             'BLOG.POSTS_PER_HOME',
        ));

        return parent::uninstall();
    }
}
