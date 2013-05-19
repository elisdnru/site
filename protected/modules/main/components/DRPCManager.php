<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

Yii::import('application.vendors.IXR_Library', true);

class DRPCManager extends CApplicationComponent
{
    public function pingPage($pageURL)
    {
        if (!$pageURL)
            return;

        $pingServers = preg_split('/\r?\n/', Yii::app()->config->get ('GENERAL.PING_SERVERS'));
        $siteName = Yii::app()->config->get('GENERAL.SITE_NAME');
        $siteHost = Yii::app()->request->getHostInfo();
        $fullPageUrl = $siteHost . $pageURL;

        if(Yii::app()->config->get ('GENERAL.PING_ENABLE'))
        {
            foreach ($pingServers as $serverUrl)
            {
                if (preg_match('|(?P<host>\w+://[\w\d\._-]+)(/?P<uri>.*)|i', $serverUrl, $matches))
                {
                    $client = new IXR_Client($matches['host'], $matches['uri']);
                    if (!$client->query('weblogUpdates.ping', array($siteName, $siteHost, $fullPageUrl)))
                        Yii::log('Ping error for ' . $serverUrl, CLogger::LEVEL_WARNING);
                }
            }
        } else
            Yii::log('Emulation of ping for ' . $fullPageUrl);
    }
}