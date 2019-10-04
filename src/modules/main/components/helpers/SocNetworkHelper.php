<?php

namespace app\modules\main\components\helpers;

class SocNetworkHelper
{
    const IMAGE_PATH = 'images/socials/';

    public static function getIcon($network)
    {
        switch ($network) {
            case 'facebook':
            case 'google':
            case 'linkedin':
            case 'liveid':
            case 'mailru':
            case 'odnoklassniki':
            case 'openid':
            case 'steam':
            case 'twitter':
            case 'vkontakte':
            case 'yandex':
            case 'youtube':
                $icon = $network . '.png';
                break;
            default:
                return false;
        }
        return '/' . self::IMAGE_PATH . $icon;
    }
}
