<?php

Yii::import('application.modules.comment.components.CommentAdminControllerBase');

class CommentController extends DController
{
    public function filters()
    {
        return array_merge(parent::filters(), [
            'accessControl',
        ]);
    }

    public function accessRules()
    {
        return [
            ['allow',
                'actions' => ['update'],
                'users' => ['?'],
            ],
            ['deny',
                'actions' => ['*'],
                'users' => ['*'],
            ],
        ];
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $form = new CommentForm('useredit');
        $form->yqe1 = 1;

        $user = $this->getUser();

        $form->attributes = $model->attributes;

        if (isset($_POST['CommentForm'])) {
            $form->attributes = $_POST['CommentForm'];

            if ($form->validate()) {
                $model->attributes = $form->attributes;

                if ($model->save()) {
                    Yii::app()->user->setFlash('commentForm', 'Ваш коментарий сохранён');
                    $this->redirect($model->url);
                }
            }
        }

        $this->render('update', [
            'model' => $model,
            'form' => $form,
            'user' => $user,
        ]);
    }

    protected function loadModel($id)
    {
        if ($this->moduleAllowed('comment')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = Comment::model()->findByPk($id, $condition);
        if ($model === null) {
            throw new CHttpException(404, 'Страница не найдена');
        }

        return $model;
    }
}
