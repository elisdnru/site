<?php

Yii::import('application.modules.user.models.*');
Yii::import('application.modules.crud.components.*');

class OrderAdminController extends DAdminController
{
    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + payed, applied, completed'
        ));
    }

    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'update'=>'DUpdateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('apply', 'payed', 'complete')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function actionPayed($id)
    {
        $model = $this->loadModel($id);
        $model->payed = $model->payed ? 0 : 1;

        if ($model->save())
            Yii::app()->user->setFlash('success', 'Отметка об оплате сохранена');
        else
            Yii::app()->user->setFlash('error', 'Ошибка сохранения');

        $this->redirectOrAjax($this->createUrl('view', array('id'=>$id)));
    }

    public function actionApplied($id)
    {
        $model = $this->loadModel($id);
        $model->apply = $model->apply ? 0 : 1;

        if ($model->save())
            Yii::app()->user->setFlash('success', 'Отметка о принятии сохранена');
        else
            Yii::app()->user->setFlash('error', 'Ошибка сохранения');

        $this->redirectOrAjax($this->createUrl('view', array('id'=>$id)));
    }

    public function actionCompleted($id)
    {
        $model = $this->loadModel($id);

        $model->complete = $model->complete ? 0 : 1;

        if (isset($_POST['code']))
            $model->post_code = $_POST['code'];

        if ($model->save())
            Yii::app()->user->setFlash('success', 'Отметка об отправке сохранена');
        else
            Yii::app()->user->setFlash('error', 'Ошибка сохранения');

        $this->redirectOrAjax($this->createUrl('view', array('id'=>$id)));
    }

    public function createModel()
    {
        return new ShopOrder();
    }

    /**
     * @param $id
     * @return ShopOrder
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ShopOrder::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404,'Страница не найдена');
        return $model;
    }
}