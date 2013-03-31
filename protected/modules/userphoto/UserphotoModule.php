<?php

class UserphotoModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'userphoto.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Загрузки';
    }

    public function getName()
    {
        return 'Личные фото';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Личные фото', 'url'=>array('/userphoto/photoAdmin/index'), 'icon'=>'images.png'),
        );
    }

    public static function notifications()
    {
        if (!Yii::app()->moduleManager->active('comment'))
            return array();

        Yii::import('application.modules.userphoto.models.UserPhotoComment');
        $comments = UserPhotoComment::model()->lang(Yii::app()->language)->count(array(
            'condition'=>'moder=0 AND type=:type',
            'params'=>array(':type'=>UserPhotoComment::TYPE_OF_COMMENT),
        ));

        return array(
            array('label'=>'Комментарии к фотографиям' . ($comments ?  ' (' . $comments . ')' : ''), 'url'=>array('/userphoto/commentAdmin/index'), 'icon'=>'comments.png'),
        );
    }

    public static function rules()
    {
        return array(
            'users/show/<username:[\w\d_-]+>/photos'=>'userphoto/default/index',
            'users/photos/<id:\d+>'=>'userphoto/photo/view',
            'addphoto'=>'userphoto/photo/create',
            'updatephoto/<id:\d+>'=>'userphoto/photo/update',
            'delphoto/<id:\d+>'=>'userphoto/photo/delete',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'USERPHOTO.ITEMS_PER_PAGE',
                'label'=>'Фотографий на странице',
                'value'=>'',
                'type'=>'string',
                'default'=>'12',
            ),array(
                'param'=>'USERPHOTO.MAX_COUNT',
                'label'=>'Максимум фотографий',
                'value'=>'',
                'type'=>'string',
                'default'=>'24',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'USERPHOTO.ITEMS_PER_PAGE',
            'USERPHOTO.MAX_COUNT',
        ));

        return parent::uninstall();
    }
}
