<?php

class PostController extends DController
{
    public function actionShow($id)
    {
        $model = $this->loadModel($id);
        $this->checkUrl($model->url);

        $this->render('show', [
            'model' => $model,
        ]);
    }

    protected function loadModel($id)
    {
        if ($this->moduleAllowed('blog')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = BlogPost::model()->findByPk($id, $condition);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
