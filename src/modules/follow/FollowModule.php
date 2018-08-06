<?php

class FollowModule extends DWebModule
{
    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'Следуйте за мной';
    }

    public function install()
    {
        Yii::app()->config->add([
            [
                'param' => 'FOLLOW.TWITTER',
                'label' => 'Логин Twitter',
                'value' => '',
                'type' => 'string',
                'default' => '',
            ],
            [
                'param' => 'FOLLOW.LIVEJOURNAL',
                'label' => 'Логин Livejournal',
                'value' => '',
                'type' => 'string',
                'default' => '',
            ],
            [
                'param' => 'FOLLOW.GITHUB',
                'label' => 'Логин Github',
                'value' => '',
                'type' => 'string',
                'default' => '',
            ],
        ]);

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete([
            'FOLLOW.TWITTER',
            'FOLLOW.LIVEJOURNAL',
            'FOLLOW.GITHUB',
        ]);

        return parent::uninstall();
    }
}
