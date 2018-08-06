<?php

class AttributeModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.attribute.models.*',
        ]);
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
        return [
            ['label' => 'Атрибуты моделей', 'url' => ['/attribute/attributeAdmin/index'], 'icon' => 'fileicon.jpg'],
        ];
    }
}
