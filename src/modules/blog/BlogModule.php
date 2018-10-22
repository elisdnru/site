<?php

class BlogModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.blog.models.*',
        ]);
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
        return [
            ['label' => 'Категории', 'url' => ['/blog/categoryAdmin/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Группы', 'url' => ['/blog/groupAdmin/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Метки', 'url' => ['/blog/tagAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Записи', 'url' => ['/blog/postAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить запись', 'url' => ['/blog/postAdmin/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications()
    {
        Yii::import('application.modules.blog.models.BlogPostComment');
        $comments = BlogPostComment::model()->count([
            'condition' => 'moder=0 AND type=:type',
            'params' => [':type' => BlogPostComment::TYPE_OF_COMMENT],
        ]);

        return [
            ['label' => 'Комментарии к записям' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/blog/commentAdmin/index'], 'icon' => 'comments.png'],
        ];
    }

    public static function rules()
    {
        return [
            'blog/feed' => 'blog/feed/index',
            'blog/search' => 'blog/default/search',
            'blog/tag/<tag:[\w-]+>/page-<page:\d+>' => 'blog/default/tag',
            'blog/tag/<tag:[\w-]+>' => 'blog/default/tag',
            'blog/date/<date:[\w-]+>/page-<page:\d+>' => 'blog/default/date',
            'blog/date/<date:[\w-]+>' => 'blog/default/date',
            'blog/<id:[\d]+>/<alias:[\w_-]+>' => 'blog/post/show',
            'blog/<id:[\d]+>' => 'blog/post/show',
            'blog/<category:[\w_\/-]+>/page-<page:\d+>' => 'blog/default/category',
            'blog/page-<page:\d+>' => 'blog/default/index',
            'blog/<category:[\w_\/-]+>' => 'blog/default/category',
            'blog' => 'blog/default/index',
        ];
    }
}
