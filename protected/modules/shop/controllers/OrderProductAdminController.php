<?php

class OrderProductAdminController extends DController
{
    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + delete',
        ));
    }

    public function actionView($id)
    {
        $order = $this->loadModel($id);

        $this->render('view', array(
            'order'=>$order,
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $prev_artikul = $model->artikul;

        if(isset($_POST['ShopOrderProduct']))
        {
            $model->attributes = $_POST['ShopOrderProduct'];

            if ($model->artikul != $prev_artikul)
            {
                if ($product = ShopProduct::model()->findByArtikul($model->artikul))
                    $model->product_id = $product->id;
                else {
                    Yii::app()->user->setFlash('editform', 'Товар не найден');
                    $this->refresh();
                }
            }

            if($model->save())
            {
                Yii::app()->user->setFlash('success', 'Изменения сохранены');
                $this->redirect($this->createUrl('/shop/orderAdmin/view', array('id'=>$model->order_id)));
            }
        }

        $this->render('update',array('model'=>$model));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if (!$model->delete())
            throw new CHttpException(400,'Ошибка удаления');

        $this->redirectOrAjax();
    }

    /**
     * @param integer $id
     * @return ShopOrderProduct
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = ShopOrderProduct::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404,'Страница не найдена');
        return $model;
    }

}