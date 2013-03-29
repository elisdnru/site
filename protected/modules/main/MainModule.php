<?php

class MainModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public static function rules()
    {
        return array(
            ''=>'main/default/index',
            'core/js/config.js'=>'main/default/configjs',
            '<action:error|url>'=>'main/default/<action>',
        );
    }

    public function install()
    {
        Yii::app()->config->add(array(
            array(
                'param'=>'GENERAL.SITE_NAME',
                'label'=>'Имя сайта',
                'value'=>'Site',
                'type'=>'string',
                'default'=>'Site',
            ),
            array(
                'param'=>'GENERAL.FEED_TITLE',
                'label'=>'Заголовок RSS ленты',
                'value'=>'RSS',
                'type'=>'string',
                'default'=>'RSS',
            ),
            array(
                'param'=>'GENERAL.FEED_URL',
                'label'=>'Адрес RSS ленты',
                'value'=>'/new/feed',
                'type'=>'string',
                'default'=>'/new/feed',
            ),
            array(
                'param'=>'GENERAL.ADMIN_EMAIL',
                'label'=>'Email администратора',
                'value'=>'mail@example.com',
                'type'=>'string',
                'default'=>'',
            ),
            array(
                'param'=>'GENERAL.SOCIAL_VK_APIID',
                'label'=>'ApiID Вконтакте',
                'value'=>'',
                'type'=>'string',
                'default'=>'0000000',
            ),
        ));

        return parent::install();
    }

    public function uninstall()
    {
        Yii::app()->config->delete(array(
            'GENERAL.SITE_NAME',
            'GENERAL.FEED_TITLE',
            'GENERAL.ADMIN_EMAIL',
            'GENERAL.SOCIAL_VK_APIID',
        ));

        return parent::uninstall();
    }
}
