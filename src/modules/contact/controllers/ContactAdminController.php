<?php

namespace app\modules\contact\controllers;

use CHttpException;
use app\modules\contact\models\Contact;
use app\modules\main\components\DAdminController;

class ContactAdminController extends DAdminController
{
    const CONTACTS_PER_PAGE = 50;

    public function actions()
    {
        return [
            'index' => [
                'class' => \app\modules\crud\components\DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'toggle' => ['class' => \app\modules\crud\components\DToggleAction::class, 'attributes' => ['status']],
            'delete' => \app\modules\crud\components\DDeleteAction::class,
            'view' => \app\modules\crud\components\DViewAction::class,
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
