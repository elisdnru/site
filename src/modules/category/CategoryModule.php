<?php

class CategoryModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.category.components.*',
            'application.modules.category.models.*',
        ]);
    }
}
