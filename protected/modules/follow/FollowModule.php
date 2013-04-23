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
        Yii::app()->config->add(array(
            array(
                'param'=>'FOLLOW.TWITTER',
                'label'=>'Логин Twitter',
                'value'=>'',
                'type'=>'string',
                'default'=>'',
            ),
            array(
                'param'=>'FOLLOW.LIVEJOURNAL',
                'label'=>'Логин Livejournal',
                'value'=>'',
                'type'=>'string',
                'default'=>'',
            ),
            array(
                'param'=>'FOLLOW.GITHUB',
                'label'=>'Логин Github',
                'value'=>'',
                'type'=>'string',
                'default'=>'',
            ),
            array(
                'param'=>'FOLLOW.FEEDBURNER',
                'label'=>'Логин Feedburner',
                'value'=>'',
                'type'=>'string',
                'default'=>'',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'FOLLOW.TWITTER',
            'FOLLOW.LIVEJOURNAL',
            'FOLLOW.GITHUB',
            'FOLLOW.FEEDBURNER',
        ));

        return parent::uninstall();
    }
}
