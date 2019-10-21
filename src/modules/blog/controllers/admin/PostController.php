<?php

namespace app\modules\blog\controllers\admin;

use app\components\crud\actions\CreateAction;
use app\components\crud\actions\DeleteAction;
use app\components\crud\actions\IndexAction;
use app\components\crud\actions\ToggleAction;
use app\components\crud\actions\UpdateAction;
use app\components\crud\actions\ViewAction;
use app\modules\blog\models\Post;
use CHttpException;
use app\components\AdminController;
use Yii;

class PostController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'create' => CreateAction::class,
            'update' => UpdateAction::class,
            'toggle' => [
                'class' => ToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => DeleteAction::class,
            'view' => ViewAction::class,
        ];
    }

    public function createModel(): Post
    {
        $model = new Post();
        $model->public = 1;
        $model->image_show = 1;
        $model->image = '';
        $model->category_id = Yii::app()->request->getParam('category');
        $model->date = date('Y-m-d H:i:s');
        $model->comments_count = 0;
        $model->comments_new_count = 0;
        return $model;
    }

    public function loadModel($id): Post
    {
        $model = Post::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
