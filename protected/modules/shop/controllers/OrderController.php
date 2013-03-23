<?php

Yii::import('user.models.*');

class OrderController extends ShopBaseController
{
    public function actionIndex()
    {
        $items = Yii::app()->shopcart->getAssoc();

        $user = $this->getUser();

        $order = $this->createOrderModel($user);

        if(isset($_POST['ShopOrder']) && count($items))
        {
            $order->attributes = $_POST['ShopOrder'];
            $order->date = date('Y-m-d H:i:s');
            $order->curs = 1;

            if (!$user)
            {
                $user = User::model()->find(array(
                    'condition' => 'email = :email',
                    'params' => array(':email'=>$order->email),
                ));
            }

            if ($user)
                $order->user_id = $user->id;

            if ($order->validate() && $order->save())
            {
                $success = true;

                foreach($items as $id=>$item)
                {
                    if ($item->model)
                    {
                        $order_product = new ShopOrderProduct;
                        $order_product->order_id = $order->id;
                        $order_product->product_id = $item->model->id;
                        $order_product->count = $item->count;

                        if (isset($_POST['ShopOrder']['product_comment'][$id]))
                            $order_product->comment = $_POST['ShopOrder']['product_comment'][$id];

                        $success = $success && $order_product->save();
                    }
                }

                if ($success)
                {
                    $order->sendEmails();
                    if ($user)
                        Yii::app()->user->setFlash('success','Заказ сохранён. Менеджер в скором времени свяжется с Вами.');
                    else
                        Yii::app()->user->setFlash('success','Заказ сохранён. Менеджер в скором времени свяжется с Вами.');

                    Yii::app()->shopcart->clear();
                    $this->refresh();
                }
                else
                {
                    $order->delete();
                    Yii::app()->user->setFlash('error','Ошибка сохранения заказа');
                }

            }
            else
                Yii::app()->user->setFlash('error','Ошибка сохранения');
        }

        $this->render('index' ,array(
            'items'=>$items,
            'user'=>$user,
            'order'=>$order,
        ));

    }

    protected function createOrderModel($user)
    {
        $order = new ShopOrder;
        $order->scenario = 'orderForm';

        if ($user)
        {
            $order->user_id = $user->id;
            $order->lastname = $user->lastname;
            $order->name = $user->name;
            $order->middlename = $user->middlename;
            $order->zip = $user->zip;
            $order->address = $user->address;
            $order->phone = $user->phone;
            $order->email = $user->email;
            return $order;
        }
        else
        {
            $order->user_id = 0;
            return $order;
        }
    }
}