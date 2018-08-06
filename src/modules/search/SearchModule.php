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

    public function install()
    {
        Yii::app()->config->add([
            [
                'param' => 'SEARCH.ITEMS_PER_PAGE',
                'label' => 'Результатов на странице поиска',
                'value' => '10',
                'type' => 'string',
                'default' => '10',
            ],
        ]);

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete([
            'SEARCH.ITEMS_PER_PAGE',
        ]);

        return parent::uninstall();
    }
}
