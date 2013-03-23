<?php

class AttributeModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'attribute.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Система';
    }

    public function getName()
    {
        return 'Атрибуты';
    }

    public static function adminMenu()
    {
        return array(
            array('label'=>'Атрибуты моделей', 'url'=>array('/attribute/attributeAdmin/index'), 'icon'=>'fileicon.jpg'),
        );
    }
}
