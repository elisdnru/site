<?php

namespace app\modules\main\components\helpers;

class SocNetworkHelper
{
    const IMAGE_PATH = 'images/soc16/';

    public static function getIcon($network)
    {
        switch ($network) {
            case 'facebook':
            case 'flickr':
            case 'google':
            case 'lastfm':
            case 'linkedin':
            case 'liveid':
            case 'livejournal':
            case 'mailru':
            case 'odnoklassniki':
            case 'openid':
            case 'soundcloud':
            case 'steam':
            case 'twitter':
            case 'vimeo':
            case 'vkontakte':
            case 'webmoney':
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