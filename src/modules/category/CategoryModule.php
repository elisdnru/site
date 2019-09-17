<?php

namespace app\modules\category;

use app\modules\main\components\system\WebModule;

class CategoryModule extends WebModule
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
