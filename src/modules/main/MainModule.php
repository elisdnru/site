<?php

class MainModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public static function rules()
    {
        return [
            '' => 'main/default/index',
            'js/config.js' => 'main/default/configjs',
            '<action:error|url>' => 'main/default/<action>',
        ];
    }
}
