<?php

Yii::import('blog.models.*');

class BookController extends DController {

    public function actionAllFree()
    {
        $url = 'http://www.books.ru/knigi-so-svobodnoi-tsenoi-3129328/?partner=' . Yii::app()->config->get('BOOKSRU.PARTNER_ID');
        $this->redirect($url);
    }

    public function actionShow($code)
    {
        $model = $this->loadModel($code);
        $this->redirect($model->getPartnerUrl());
    }

    /**
     * @param $code
     * @return Book
     * @throws CHttpException
     */
    protected function loadModel($code)
    {
        $model = Book::model()->findByCode($code);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}