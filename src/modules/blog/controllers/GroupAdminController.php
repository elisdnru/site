<?php

Yii::import('application.modules.crud.components.*');

/**
 * @method renderTableForm($params)
 */
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
            'class' => 'BlogPostGroup',
            'order' => 'title ASC',
            'form' => 'BlogPostGroupForm',
            'view' => 'index',
        ]);
    }

    public function beforeDelete($model)
    {
        $count = BlogPost::model()->count(
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
        $model = BlogPostGroup::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
