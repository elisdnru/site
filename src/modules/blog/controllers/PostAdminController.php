<?php

Yii::import('application.modules.crud.components.*');

class PostAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'DAdminAction',
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => 'DCreateAction',
            'update' => 'DUpdateAction',
            'toggle' => [
                'class' => 'DToggleAction',
                'attributes' => ['public']
            ],
            'delete' => 'DDeleteAction',
            'view' => 'DViewAction',
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
        if (DMultilangHelper::enabled()) {
            $model = BlogPost::model()->multilang()->findByPk($id);
        } else {
            $model = BlogPost::model()->findByPk($id);
        }

        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
