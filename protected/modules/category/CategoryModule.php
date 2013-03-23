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
            'category.components.*',
            'category.models.*',
        ));
    }
}
