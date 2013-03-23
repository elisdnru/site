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
            //array('label'=>'Галереи', 'url'=>array('/userphoto/galleryAdmin/index'), 'icon'=>'images.png'),
        );
    }

    public static function rules()
    {
        return array(
            'users/show/<username:[\w\d_-]+>/photos'=>'userphoto/default/index',
            'addphoto/<id:\d+>'=>'userphoto/image/view',
            'addphoto'=>'userphoto/image/create',
            'delphoto/<id:\d+>'=>'userphoto/image/delete',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
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
            'USERPHOTO.MAX_COUNT',
        ));

        return parent::uninstall();
    }
}
