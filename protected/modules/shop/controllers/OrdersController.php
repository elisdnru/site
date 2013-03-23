<?php

class OrdersController extends ShopBaseController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array(Access::ROLE_USER),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $orders = ShopOrder::model()->findAll(array(
            'condition'=>'user_id = :uid',
            'params'=>array(':uid'=>Yii::app()->user->id),
            'order'=>'id DESC'
        ));

        $this->render('index', array(
            'user'=>$this->getUser(),
            'orders'=>$orders,
        ));
    }

    public function actionShow($id)
    {
        $model = $this->loadModel($id);

        $this->render('show', array(
            'user'=>$this->getUser(),
            'model'=>$model,
        ));
    }

    public function actionPay($id)
    {
        $model = $this->loadModel($id);

        $this->render('pay', array(
            'user'=>$this->getUser(),
            'model'=>$model,
        ));
    }

    protected function loadModel($id)
    {
        $model = ShopOrder::model()->find(array(
            'condition' => 'id=:id AND user_id = :uid',
            'params' => array(':id'=>$id, ':uid'=>Yii::app()->user->id),
        ));

        if ($model === null)
            throw new CHttpException(404, 'Заказ не найден');

        return $model;
    }
}
