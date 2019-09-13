<?php

namespace app\modules\blog\controllers;

use BlogPost;
use BlogTag;
use CHttpException;
use CJSON;
use DAdminController;
use Yii;

class PostAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \DCreateAction::class,
            'update' => \DUpdateAction::class,
            'toggle' => [
                'class' => \DToggleAction::class,
                'attributes' => ['public']
            ],
            'delete' => \DDeleteAction::class,
            'view' => \DViewAction::class,
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
        $model->category_id = Yii::app()->request->getParam('category');
        $model->date = date('Y-m-d H:i:s');
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
