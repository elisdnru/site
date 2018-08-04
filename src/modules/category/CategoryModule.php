<?php

class CategoryModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'application.modules.category.components.*',
            'application.modules.category.models.*',
        ));
    }
}
