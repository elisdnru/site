<?php

Yii::import('crud.components.*');
DUrlRulesHelper::import('users');

class CommentAdminControllerBase extends DAdminController
{
    const COMMENTS_PER_PAGE = 20;

    public function init()
    {
        $this->registerScripts();
    }

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + delete, moder, moderAll',
        ));
    }

    public function actions()
    {
        return array(
            'update'=>'DUpdateAction',
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('public', 'moder')
            ),
            'view'=>'DViewAction',
        );
    }

    public function actionIndex($id=0)
    {
        $criteria = new CDbCriteria;

        if ($id && $material = $this->loadMaterialModel($id))
            $criteria->compare('material_id', $id);
        else
            $material = null;

        $dataProvider = new CActiveDataProvider(call_user_func(array($this->getModelName(), 'model'))->lang(Yii::app()->language), array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'t.date DESC'
            ),
            'pagination'=>array(
                'pageSize'=>self::COMMENTS_PER_PAGE,
                'pageVar'=>'page',
            )
        ));

        if (Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('comment.views.commentAdmin._list',array(
                'dataProvider'=>$dataProvider,
            ));
        }
        else
        {
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
                'material'=>$material,
            ));
        }
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if ($model->childs)
        {
            $model->public = false;
            $success = $model->save(false);
        }
        else
            $success = $model->delete();

        if (!$success)
            throw new CHttpException (400, 'Error');

        $this->redirectOrAjax();
    }

    public function actionModer($id)
    {
        $model = $this->loadModel($id);

        $model->moder = !$model->moder;

        if (!$model->save())
            throw new CHttpException (400, 'Error');

        $this->redirectOrAjax();
    }

    public function actionModerAll()
    {
        $items = CActiveRecord::model($this->getModelName())->findAllByAttributes(array('moder'=>0));

        foreach ($items as $item)
        {
            $item->moder = 1;
            $item->save();
        }

        $this->redirectOrAjax();
    }

    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->getModelName())->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Комментарий не найден');
        return $model;
    }

    protected function loadMaterialModel($id)
    {
        throw new CException('Undefined material model');
        return null;
    }

    protected function getModelName()
    {
        return 'Comment';
    }

    protected function registerScripts()
    {
        $url = CHtml::asset(Yii::getPathOfAlias('comment.assets.comments') . '.css');
        Yii::app()->clientScript->registerCssFile($url);
    }
}