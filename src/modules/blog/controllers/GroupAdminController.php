<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogPostGroup;
use CHttpException;
use app\components\AdminController;

/**
 * @method renderTableForm($params)
 */
class GroupAdminController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\components\crud\actions\TableInputAction::class,
                'modelClass' => BlogPostGroup::class,
                'formClass' => \app\modules\blog\models\BlogPostGroupForm::class,
                'order' => 'title ASC',
                'view' => 'index',
            ],
            'delete' => \app\components\crud\actions\DeleteAction::class,
        ];
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
