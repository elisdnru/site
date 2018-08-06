<?php

DUrlRulesHelper::import('new');
Yii::import('application.modules.page.models.Page');

class HomeNewsWidget extends DWidget
{
    public $tpl = 'default';
    public $limit = 6;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published', 'inhome'];

        $criteria->limit = $this->limit;
        $criteria->order = 'date desc';

        $news = News::model()->findAll($criteria);

        $this->render('HomeNews/' . $this->tpl, [
            'news' => $news,
        ]);
    }
}
