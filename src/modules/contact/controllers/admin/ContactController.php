<?php

namespace app\modules\contact\controllers\admin;

use CHttpException;
use app\modules\contact\models\Contact;
use app\components\AdminController;

class ContactController extends AdminController
{
    const CONTACTS_PER_PAGE = 50;

    public function actions(): array
    {
        return [
            'index' => [
                'class' => \app\components\crud\actions\AdminAction::class,
                'view' => 'index',
            ],
            'toggle' => ['class' => \app\components\crud\actions\ToggleAction::class, 'attributes' => ['status']],
            'delete' => \app\components\crud\actions\DeleteAction::class,
            'view' => \app\components\crud\actions\ViewAction::class,
        ];
    }

    public function actionView($id): void
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

    public function createModel(): Contact
    {
        return new Contact();
    }

    public function loadModel($id): Contact
    {
        $model = Contact::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
