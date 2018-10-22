<?php

class GalleryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.gallery.components.*',
            'application.modules.gallery.models.*',
        ]);
    }

    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Галереи';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Категории', 'url' => ['/gallery/categoryAdmin/index'], 'icon' => 'foldericon.jpg'],
            ['label' => 'Материалы', 'url' => ['/gallery/photoAdmin/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить материал', 'url' => ['/gallery/photoAdmin/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications()
    {
        Yii::import('application.modules.gallery.models.GalleryPhotoComment');
        $comments = GalleryPhotoComment::model()->count([
            'condition' => 'moder=0 AND type=:type',
            'params' => [':type' => GalleryPhotoComment::TYPE_OF_COMMENT],
        ]);

        return [
            ['label' => 'Комментарии к фото' . ($comments ? ' (' . $comments . ')' : ''), 'url' => ['/gallery/commentAdmin/index'], 'icon' => 'comments.png'],
        ];
    }

    public static function rules()
    {
        return [
            'gallery/<id:[\d]+>' => 'gallery/photo/show',
            'gallery/<category:[\w_\/-]+>/page-<page:\d+>' => 'gallery/default/category',
            'gallery/page-<page:\d+>' => 'gallery/default/index',
            'gallery/<category:[\w_\/-]+>' => 'gallery/default/category',
            'gallery' => 'gallery/default/index',
        ];
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/modules/gallery.css');
    }
}
