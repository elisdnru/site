<?php

DUrlRulesHelper::import('new');

class NewsWidget extends DWidget
{
    public $tpl = 'default';
    public $page = '';
    public $childs = true;

    public function run()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = ['published'];
        $criteria->order = 't.date desc';

        if ($this->page) {
            if ($layout = NewsPage::model()->getListLayout($this->page->id)) {
                $this->tpl = $layout;
            }

            if ($this->childs) {
                $criteria->addInCondition('t.page_id', array_unique(CArray::merge([$this->page->id], $this->page->getChildsArray())));
            } else {
                $criteria->addCondition('t.page_id=:category');
                $criteria->params[':category'] = $this->page->getPrimaryKey();
            }
        }

        $count = News::model()->cache(0, new Tags('new'))->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = Yii::app()->params['NEW.NEWS_PER_PAGE'];
        $pages->applyLimit($criteria);

        $criteria->with = ['page', 'files'];
        $news = News::model()->cache(0, new Tags('new'))->findAll($criteria);

        $this->render('News/' . $this->tpl, [
            'news' => $news,
            'pages' => $pages,
        ]);
    }
}
