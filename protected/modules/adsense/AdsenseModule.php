<?php

class AdsenseModule extends DWebModule
{
    public static function system()
    {
        return false;
    }

    public function getGroup()
    {
        return 'Реклама';
    }

    public function getName()
    {
        return 'Google Adsense';
    }
}
