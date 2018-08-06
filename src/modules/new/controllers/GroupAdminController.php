<?php

Yii::import('application.modules.crud.components.*');

class GroupAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'delete' => 'DDeleteAction',
        ];
    }

    public function behaviors()
    {
        return array_replace(parent::behaviors(), [
            'tableInputBehavior' => ['class' => 'DTableInputBehavior'],
        ]);
    }

    public function actionIndex()
    {
        $this->renderTableForm([
            'class' => 'NewsGroup',
            'order' => 'title ASC',
            'form' => 'NewsGroupForm',
            'view' => 'index',
        ]);
    }

    public function beforeDelete($model)
    {
        $count = News::model()->count(
            [
                'condition' => 't.group_id = :ID',
                'params' => [':ID' => $model->id]
            ]
        );

        if ($count) {
            throw new CHttpException(400, 'В данной группе есть новости. Удалите их или переместите в другие группы.');
        }
    }

    public function loadModel($id)
    {
        $model = NewsGroup::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
