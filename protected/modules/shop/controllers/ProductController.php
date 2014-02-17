<?php

Yii::import('application.modules.page.models.*');

class ProductController extends ShopBaseController
{

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'postOnly +rating',
        ));
    }

    public function actionShow($id)
    {
        $model = $this->loadModel($id);

        $this->checkUrl($model->url);

        $this->render('show', array(
            'model'=>$model,
            'page'=>$this->loadShopPage(),
        ));
    }

    public function actionRating($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['rate']))
            $model->updateRating($_POST['rate']);

        $this->redirectOrAjax($model->url);
    }

    protected function loadShopPage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByPath('shop'))
        {
            $page = new Page;
            $page->title = 'Каталог';
            $page->pagetitle = $page->title;
        }
        return $page;
    }

    /**
     * @param $id
     * @return ShopProduct
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        if($this->moduleAllowed('shop'))
            $condition = '';
        else
            $condition = 'public = 1';

        $model = ShopProduct::model()->findByPk($id, $condition);
        if($model === null)
            throw new CHttpException(404, 'Страница не найдена');

        return $model;
    }
}