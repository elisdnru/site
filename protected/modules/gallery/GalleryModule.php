<?php

class GalleryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.gallery.components.*',
            'application.modules.gallery.models.*',
        ));
    }

    public static function system()
    {
        return false;
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
        return array(
            array('label'=>'Категории', 'url'=>array('/gallery/categoryAdmin/index'), 'icon'=>'foldericon.jpg'),
            array('label'=>'Материалы', 'url'=>array('/gallery/photoAdmin/index'), 'icon'=>'fileicon.jpg'),
            array('label'=>'Добавить материал', 'url'=>array('/gallery/photoAdmin/create'), 'icon'=>'add.png'),
        );
    }

    public static function notifications()
    {
        if (!Yii::app()->moduleManager->active('comment'))
            return array();

        Yii::import('application.modules.gallery.models.GalleryPhotoComment');
        $comments = GalleryPhotoComment::model()->lang(Yii::app()->language)->count(array(
            'condition'=>'moder=0 AND type=:type',
            'params'=>array(':type'=>GalleryPhotoComment::TYPE_OF_COMMENT),
        ));

        return array(
            array('label'=>'Комментарии к фото' . ($comments ?  ' (' . $comments . ')' : ''), 'url'=>array('/gallery/commentAdmin/index'), 'icon'=>'comments.png'),
        );
    }

    public static function rules()
    {
        return array(
            'gallery/<id:[\d]+>'=>'gallery/photo/show',
            'gallery/<category:[\w_\/-]+>/page-<page:\d+>'=>'gallery/default/category',
            'gallery/page-<page:\d+>'=>'gallery/default/index',
            'gallery/<category:[\w_\/-]+>'=>'gallery/default/category',
            'gallery'=>'gallery/default/index',
        );
    }

    public static function registerScripts()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/modules/gallery.css');
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'GALLERY.PHOTOS_PER_PAGE',
                'label'=>'Материалов на странице',
                'value'=>'20',
                'type'=>'string',
                'default'=>'20',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'GALLERY.PHOTOS_PER_PAGE',
        ));

        return parent::uninstall();
    }
}
