<?php

namespace app\modules\block;

use DWebModule;

class BlockModule extends DWebModule
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function init()
    {
        parent::init();

        $this->setImport([
            'application.modules.block.models.*',
        ]);
    }

    public function getGroup()
    {
        return 'Настройки и шаблоны';
    }

    public function getName()
    {
        return 'HTML-блоки';
    }

    public static function adminMenu()
    {
        return [
            ['label' => 'Блоки', 'url' => ['/block/blockAdmin/index'], 'icon' => 'code.png'],
            ['label' => 'Добавить блок', 'url' => ['/block/blockAdmin/create'], 'icon' => 'add.png'],
        ];
    }
}
