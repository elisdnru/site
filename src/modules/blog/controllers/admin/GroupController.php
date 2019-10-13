<?php

namespace app\modules\blog\controllers\admin;

use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use CHttpException;
use app\components\AdminController;

/**
 * @method renderTableForm($params)
 */
class GroupController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\components\crud\actions\TableInputAction::class,
                'modelClass' => Group::class,
                'formClass' => \app\modules\blog\forms\GroupForm::class,
                'order' => 'title ASC',
                'view' => 'index',
            ],
            'delete' => \app\components\crud\actions\DeleteAction::class,
        ];
    }

    public function beforeDelete($model)
    {
        $count = Post::model()->count(
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
        $model = Group::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
