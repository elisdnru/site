<?php

Yii::import('application.modules.page.models.Page');

class DefaultController extends DController
{
	public function actionIndex()
	{
        $this->render('index', array(
            'page'=>$this->loadIndexPage(),
        ));
	}

    public function actionUrl($a){
        $this->redirect($a);
        Yii::app()->end();
    }

    public function actionConfigjs()
    {
        header('Content-Type: application/x-javascript');
        echo $this->renderPartial('config', null, true);
        Yii::app()->end();
    }

    protected function loadIndexPage()
    {
        if (!$page = Page::model()->findByAlias('index'))
        {
            $page = new Page();
            $page->title = 'Главная';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}