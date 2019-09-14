<?php

namespace app\modules\user\controllers;

use CActiveForm;
use CHttpException;
use app\modules\main\components\DAdminController;
use app\modules\page\models\Page;
use app\modules\user\models\User;
use app\modules\user\models\UserPage;
use Yii;

class UserAdminController extends DAdminController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => \app\modules\crud\components\DAdminAction::class,
                'view' => 'index',
                'ajaxView' => '_grid'
            ],
            'create' => \app\modules\crud\components\DCreateAction::class,
            'update' => \app\modules\crud\components\DUpdateAction::class,
            'toggle' => [
                'class' => \app\modules\crud\components\DToggleAction::class,
                'attributes' => ['active']
            ],
            'delete' => \app\modules\crud\components\DDeleteAction::class,
            'view' => \app\modules\crud\components\DViewAction::class,
        ];
    }

    public function actionAccessAdd($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['AccessPage'])) {
            if ($page = Page::model()->findByPk($_POST['AccessPage']['page'])) {
                $userPage = UserPage::model()->find([
                    'condition' => 'user_id=:user AND page_id=:page',
                    'params' => [':user' => $model->id, ':page' => $page->id]
                ]);

                if (!$userPage) {
                    $userPage = new UserPage();
                    $userPage->page_id = $page->id;
                    $userPage->user_id = $model->id;
                    if ($userPage->save()) {
                        Yii::app()->user->setFlash('success', 'Раздел добавлен');
                        $this->refresh();
                    }
                }
            }
        }

        $this->redirect($this->createUrl('update', ['id' => $id]));
    }

    public function actionAccessDel($id)
    {
        $this->checkIsPost();

        $model = $this->loadAccessPageModel($id);

        if (!$model->delete()) {
            throw new CHttpException(400, 'Ошибка удаления');
        }

        $this->redirectOrAjax();
    }

    public function createModel()
    {
        $model = new User(User::SCENARIO_ADMIN_CREATE);
        return $model;
    }

    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'Не найдено');
        }
        $model->scenario = User::SCENARIO_ADMIN_UPDATE;
        return $model;
    }

    protected function loadAccessPageModel($id)
    {
        $model = UserPage::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Не найдено');
        }
        return $model;
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
