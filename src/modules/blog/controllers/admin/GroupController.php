<?php

namespace app\modules\blog\controllers\admin;

use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\TableInputAction;
use app\modules\blog\forms\GroupForm;
use app\modules\blog\models\Post;
use app\modules\blog\models\Group;
use CHttpException;
use app\components\AdminController;

/**
 * @method renderTableForm($params)
 */
class GroupController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => [
                'class' => TableInputAction::class,
                'modelClass' => Group::class,
                'formClass' => GroupForm::class,
                'order' => 'title ASC',
                'view' => 'index',
            ],
            'delete' => DeleteAction::class,
        ];
    }

    public function beforeDelete($model): void
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

    public function loadModel($id): Group
    {
        $model = Group::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
