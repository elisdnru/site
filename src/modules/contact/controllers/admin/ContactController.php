<?php

namespace app\modules\contact\controllers\admin;

use app\modules\contact\forms\ContactSearch;
use CHttpException;
use app\modules\contact\models\Contact;
use app\components\AdminController;

class ContactController extends AdminController
{
    public function actions(): array
    {
        return [
            'index' => \app\components\crud\actions\v2\IndexAction::class,
            'toggle' => [
                'class' => \app\components\crud\actions\v2\ToggleAction::class,
                'attributes' => ['status'],
            ],
            'delete' => \app\components\crud\actions\v2\DeleteAction::class,
            'view' => \app\components\crud\actions\v2\ViewAction::class,
        ];
    }

    public function actionView($id): void
    {
        $model = $this->loadModel($id);

        $prev = Contact::find()->andWhere(['<', 'id', $id])->orderBy(['id' => SORT_DESC])->limit(1)->one();
        $next = Contact::find()->andWhere(['>', 'id', $id])->orderBy(['id' => SORT_ASC])->limit(1)->one();

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

    public function createSearchModel(): ContactSearch
    {
        return new ContactSearch();
    }

    public function loadModel($id): Contact
    {
        $model = Contact::findOne($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }
}
