<?php

Yii::import('page.models.*');

class DNewUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $cache = 0;

    public function createUrl($manager,$route,$params,$ampersand)
    {
        if ($route==='new/new/show')
        {
            if (isset($params['id']))
            {
                if (!$model = News::model()->cache($this->cache)->findByPk($params['id']))
                    return false;

                if (isset($params['path'], $params['id'], $params['alias']))
                    return $params['path'] . '/' . $params['id'] . '/' . $params['alias'] . (isset($params['page']) ? '/page-' . (int)$params['page'] : '');
            }
        }
        return false;
    }

    public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
    {
        if (preg_match('|^(?P<path>[\w\d_/-]+)/(?P<id>\d+)(/(?P<alias>[\w\d_-]+))?$|', $pathInfo, $matches))
        {
            if (Yii::app()->hasModule($matches['path']))
                return false;

            $command = Yii::app()->db->cache($this->cache)->createCommand( 'SELECT * FROM {{new}} WHERE id=:id' );
            $command->bindParam(':id', $matches['id'], PDO::PARAM_INT);
            $id = $command->queryRow();

            if ($id)
            {
                if (isset($matches['path'])) $_GET['path'] = $matches['path'];
                if (isset($matches['id'])) $_GET['id'] = $matches['id'];
                if (isset($matches['alias'])) $_GET['alias'] = $matches['alias'];

                return 'new/new/show';
            }
        }
        return false;
    }
}
