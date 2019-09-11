<?php

namespace app\modules\search;

use DWebModule;

class SearchModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.search.components.*',
            'application.modules.search.models.*',
        ]);
    }


    public function getGroup()
    {
        return 'Контент';
    }

    public function getName()
    {
        return 'Поиск';
    }

    public static function rules()
    {
        return [
            'search' => 'search/default/index',
        ];
    }
}
