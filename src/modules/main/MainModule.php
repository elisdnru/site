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
            'js/config.js'=>'main/default/configjs',
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
            array(
                'param'=>'GENERAL.PING_ENABLE',
                'label'=>'Пинговать поисковые системы',
                'value'=>'',
                'type'=>'checkbox',
                'default'=>'0',
            ),
            array(
                'param'=>'GENERAL.PING_SERVERS',
                'label'=>'Адреса пинга',
                'value'=>implode(PHP_EOL , array(
                    'http://ping.blogs.yandex.ru/RPC2',
                    'http://blogsearch.google.com/ping/RPC2',
                )),
                'type'=>'text',
                'default'=>'',
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