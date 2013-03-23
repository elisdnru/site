<?php

class CartController extends ShopBaseController
{
    public function actionIndex()
    {
        $items = Yii::app()->shopcart->getAssoc();

        if (!count($items))
            $this->redirect($this->createUrl('/shop'));

        if(isset($_POST['Cart']))
        {
            foreach($items as $id=>$item)
            {
                if(isset($_POST['Cart'][$id]))
                {
                    if ($item->model)
                    {
                        $exist = $item->model->count;
                        $newcount = (int)$_POST['Cart'][$id]['count'];
                        Yii::app()->shopcart->set($id, $newcount <= $exist ? $newcount : $exist);
                    }
                }
            }
            $items = Yii::app()->shopcart->getAssoc();
        }

        $this->render('cart' ,array(
            'items'=>$items,
        ));
    }

    public function actionAdd()
    {
        if (isset($_POST['ToCart']))
        {
            $item = new ShopCartItem();
            $item->attributes = $_POST['ToCart'];

            if ($item->validate())
            {
                Yii::app()->shopcart->add($item);
                if (!Yii::app()->request->isAjaxRequest)
                    Yii::app()->user->setFlash('success', 'Товар добавлен в корзину');
            }
        }

        $this->redirectOrAjax(Yii::app()->request->urlReferrer ? Yii::app()->request->urlReferrer : array('/shop'));
    }

    public function actionRemove($id)
    {
        Yii::app()->shopcart->remove($id);
        $this->redirectOrAjax();
    }

    public function actionClear()
    {
        Yii::app()->shopcart->clear();
        $this->redirectOrAjax();
    }

    public function actionFrame($id)
    {
        $model = ShopProduct::model()->findByPk($id);
        $this->layout = '//layouts/iframe';

        $this->render('frametocart', array(
            'model'=>$model,
        ));
    }

    public function actionMinicart()
    {
        if (Yii::app()->request->isAjaxRequest)
            $this->widget('shop.widgets.ShopCartWidget');
        else
            throw new CHttpException(400);
    }
}