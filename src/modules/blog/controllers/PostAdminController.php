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
                'class' => \app\modules\crud\components\AdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\modules\crud\components\CreateAction::class,
            'update' => \app\modules\crud\components\UpdateAction::class,
            'toggle' => [
                'class' => \app\modules\crud\components\ToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => \app\modules\crud\components\DeleteAction::class,
            'view' => \app\modules\crud\components\ViewAction::class,
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
