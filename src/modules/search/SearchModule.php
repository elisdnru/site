<?php

class SearchModule extends DWebModule
{
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
