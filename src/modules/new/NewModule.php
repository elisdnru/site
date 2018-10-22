<?php

class NewModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.new.models.*',
        ]);
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Новости';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Новостные страницы', 'url' => ['/new/pageAdmin'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Темы', 'url' => ['/new/groupAdmin'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Новости/Статьи', 'url' => ['/new/newAdmin'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить новость', 'url' => ['/new/newAdmin/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications()
    {
        if (!Yii::app()->moduleManager->active('comment')) {
            return [];
        }

        $comments = NewsComment::model()->count([
            'condition' => 'moder=0 AND type=:type',
            'params' => [':type' => NewsComment::TYPE_OF_COMMENT],
        ]);

        return [
            ['label' => 'Комментарии к новостям' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/new/commentAdmin/index'], 'icon' => 'comments.png'],
        ];
    }

    public static function rules()
    {
        return [
            'new/feed' => 'new/feed/index',
            ['class' => 'new.components.DNewUrlRule', 'cache' => 3600 * 24],
        ];
    }
}
