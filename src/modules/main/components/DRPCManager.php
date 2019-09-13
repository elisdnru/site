<?php

class DRPCManager extends CApplicationComponent
{
    public function pingPage($pageURL)
    {
        if (!$pageURL) {
            return;
        }

        $pingServers = Yii::app()->params['GENERAL.PING_SERVERS'];
        $siteName = Yii::app()->params['GENERAL.SITE_NAME'];
        $siteHost = Yii::app()->request->getHostInfo();
        $fullPageUrl = $siteHost . $pageURL;

        if (Yii::app()->params['GENERAL.PING_ENABLE']) {
            foreach ($pingServers as $serverUrl) {
                if (preg_match('|(?P<host>\w+://[\w\d\._-]+)/?(?P<uri>.*)|i', $serverUrl, $matches)) {
                    $client = new IXR_Client($matches['host'], $matches['uri']);
                    if (!$client->query('weblogUpdates.ping', [$siteName, $siteHost, $fullPageUrl])) {
                        Yii::log('Ping error for ' . $serverUrl, CLogger::LEVEL_WARNING);
                    }
                }
            }
        } else {
            Yii::log('Emulation of ping for ' . $fullPageUrl);
        }
    }
}
