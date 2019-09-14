<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostGroup;
use CHttpException;
use app\modules\main\components\DAdminController;

/**
 * @method renderTableForm($params)
 */
class GroupAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'delete' => \app\modules\crud\components\DDeleteAction::class,
        ];
    }

    public function behaviors()
    {
        return array_replace(parent::behaviors(), [
            'tableInputBehavior' => ['class' => \app\modules\crud\components\DTableInputBehavior::class],
        ]);
    }

    public function actionIndex()
    {
        $this->renderTableForm([
            'class' => BlogPostGroup::class,
            'order' => 'title ASC',
            'form' => \app\modules\blog\models\BlogPostGroupForm::class,
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
