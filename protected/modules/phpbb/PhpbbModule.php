<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class PhpbbModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'phpbb.models.*',
        ));
    }

    public function getGroup()
    {
        return 'Форум';
    }

    public function getName()
    {
        return 'PhpBB';
    }
}
