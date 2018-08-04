<?php

Yii::import('application.modules.page.models.*');

class DPageUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $cache = 0;

    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='page/page/show')
        {
            if (isset($params['path']))
                return $params['path'] . (isset($params['page']) ? '/page-' . (int)$params['page'] : '');
        }
        return false;
    }

    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (
            preg_match('|^(?P<path>\w[\w\d_/-]+)/page-(?P<page>\d+)$|', $pathInfo, $matches) ||
            preg_match('|^(?P<path>\w[\w\d_/-]+)$|', $pathInfo, $matches)
        )
        {
            if (Yii::app()->hasModule($matches['path']))
                return false;

            if (Page::model()->cache($this->cache)->findByPath($matches['path']))
            {
                $_GET['path'] = $matches['path'];

                if (isset($matches['page']))
                    $_GET['page'] = $matches['page'];

                return 'page/page/show';
            }
        }
        return false;
    }
}
