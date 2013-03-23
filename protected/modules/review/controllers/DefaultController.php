<?php

Yii::import('application.modules.page.models.Page');

class DefaultController extends DController
{
    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'DCaptchaAction',
            ),
        );
    }

    public function actionIndex()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array('published');

        $count = Review::model()->cache(30)->count($criteria);

        $pages = new CPagination($count);
        $pages->pageSize = Yii::app()->config->get('GENERAL.NEWS_PER_PAGE');
        $pages->applyLimit($criteria);

        $criteria->order = 't.date DESC';
        $reviews = Review::model()->cache(30)->findAll($criteria);

        $reviewForm = new ReviewForm;

        if (isset($_POST['ReviewForm']))
        {
            $reviewForm->attributes = $_POST['ReviewForm'];
            if ($reviewForm->validate())
            {
                $review = new Review();
                $review->attributes = $_POST['ReviewForm'];

                if ($review->save())
                {
                    Yii::app()->user->setFlash('success','Спасибо. Ваш отзыв отпрален на проверку.');
                    $this->refresh();
                }
            }
        }

        $this->render('index', array(
            'reviews'=>$reviews,
            'pages'=>$pages,
            'page'=>$this->loadReviewPage(),
            'reviewForm'=>$reviewForm,
        ));
    }

    protected function loadReviewPage()
    {
        if (!$page = Page::model()->findByAlias('reviews'))
        {
            $page = new Page;
            $page->title = 'Отзывы';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}