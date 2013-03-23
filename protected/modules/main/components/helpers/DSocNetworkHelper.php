<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DSocNetworkHelper
{
    const IMAGE_PATH = 'core/images/soc16/';

    public static function getIcon($network)
    {
        switch ($network)
        {
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
            default: return false;
        }
        return Yii::app()->request->baseUrl . '/' . self::IMAGE_PATH . $icon;
    }
}
