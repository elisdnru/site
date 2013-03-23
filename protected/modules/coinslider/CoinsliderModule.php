<?php

class CoinsliderModule extends DWebModule
{
    public static function system()
    {
        return true;
    }

    public function getGroup()
    {
        return 'Прочее';
    }

    public function getName()
    {
        return 'CoinSlider';
    }
}
