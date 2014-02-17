<?php

Yii::import('application.modules.page.models.Page');

class ReviewController extends DController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
        );
    }

    public function actionShow($id)
	{
        $review = $this->loadModel($id);

		$this->render('show', array(
            'review'=>$review,
            'page'=>$this->loadReviewPage(),
        ));
	}

    protected function loadModel($id)
    {
        $model = Review::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }

    protected function loadReviewPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('reviews'))
        {
            $page = new Page;
            $page->title = 'Отзывы';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}