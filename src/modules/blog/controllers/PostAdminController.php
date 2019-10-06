<?php

namespace app\modules\blog\controllers;

use app\modules\blog\models\BlogPost;
use app\modules\blog\models\BlogTag;
use CHttpException;
use CJSON;
use app\components\AdminController;
use Yii;

class PostAdminController extends AdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\components\crud\actions\AdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\components\crud\actions\CreateAction::class,
            'update' => \app\components\crud\actions\UpdateAction::class,
            'toggle' => [
                'class' => \app\components\crud\actions\ToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function actionAutoCompleteTags($term)
    {
        if ($term) {
            $tags = BlogTag::model()->getArrayByMatch($term);
            echo CJSON::encode($tags);
            Yii::app()->end();
        }
    }

    public function createModel()
    {
        $model = new BlogPost();
        $model->public = 1;
        $model->image_show = 1;
        $model->image = '';
        $model->category_id = Yii::app()->request->getParam('category');
        $model->date = date('Y-m-d H:i:s');
        $model->comments_count = 0;
        $model->comments_new_count = 0;
        return $model;
    }

    public function loadModel($id)
    {
        $model = BlogPost::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
