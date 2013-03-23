<?php

class UloginModule extends DWebModule
{
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'ulogin.components.*',
            'ulogin.models.*',
        ));
    }

    public static function system()
    {
        return true;
    }

    public static function rules()
    {
        return array(
            'ulogin'=>'ulogin/default/login',
        );
    }
}
