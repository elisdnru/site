<?php

class PaymentController extends ShopBaseController
{
    public function actionPay($id)
    {
        $order = $this->loadModel($id);

        $amount = $order->fullSumm;
        $orderId = $order->id;
        $description = 'Оплата заказа ' . $order->fullId;
        $clientEmail = $order->email;
        Yii::app()->rc->pay($amount, $orderId, $description, $clientEmail);
    }

    public function actionProcess()
    {
        Yii::app()->rc->result();
        Yii::app()->end();
    }

    public function actionSuccess()
    {
        echo 'Success';
    }
    public function actionFail()
    {
        echo 'Error';
    }

    protected function loadModel($id)
    {
        $model = ShopOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Заказ не найден');

        return $model;
    }
}
