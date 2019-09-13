<?php

namespace app\modules\contact\controllers;

use CHttpException;
use Contact;
use DAdminController;

class ContactAdminController extends DAdminController
{
    const CONTACTS_PER_PAGE = 50;

    public function actions()
    {
        return [
            'index' => [
                'class' => \DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'toggle' => ['class' => \DToggleAction::class, 'attributes' => ['status']],
            'delete' => \DDeleteAction::class,
            'view' => \DViewAction::class,
        ];
    }

    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $model->status = 1;
        $model->save();

        $prev = Contact::model()->find([
            'condition' => 'id < ?',
            'params' => [$id],
            'order' => 'id DESC',
            'limit' => 1
        ]);

        $next = Contact::model()->find([
            'condition' => 'id > ?',
            'params' => [$id],
            'order' => 'id ASC',
            'limit' => 1
        ]);

        $this->render('view', [
            'model' => $model,
            'prev' => $prev,
            'next' => $next,
        ]);
    }

    public function createModel()
    {
        $model = new Contact();
        return $model;
    }

    public function loadModel($id)
    {
        $model = Contact::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
