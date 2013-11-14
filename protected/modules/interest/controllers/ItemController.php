<?php

class ItemController extends DController {

    public function actionAll()
    {
        $url = Yii::app()->config->get('INTEREST.ALL_LINK');
        $this->redirect($url);
    }

    public function actionShow($id)
    {
        $model = $this->loadModel($id);
        $this->redirect($model->getPartnerUrl());
    }

    /**
     * @param $id
     * @return InterestItem
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = InterestItem::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');
        return $model;
    }
}