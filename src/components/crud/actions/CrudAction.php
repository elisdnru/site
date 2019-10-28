<?php

namespace app\components\crud\actions;

use app\components\crud\Messages;
use CAction;
use CActiveRecord;
use CException;
use CHttpException;
use Yii;

class CrudAction extends CAction
{
    /*
     * @var string $flash key for Yii::app()->user->setFlash($flashSuccess, $message);
     */
    public $flashSuccess = 'success';
    /*
     * @var string $flash key for Yii::app()->user->setFlash($flashError, $message);
     */
    public $flashError = 'error';

    protected function checkIsPostRequest(): void
    {
        if (!Yii::$app->request->isPost) {
            throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));
        }
    }

    protected function clientCallback($method, $model): void
    {
        if (method_exists($this->controller, $method)) {
            $this->controller->$method($model);
        }
    }

    protected function success($message): void
    {
        if (!Yii::$app->request->getIsAjax()) {
            Yii::app()->user->setFlash($this->flashSuccess, Yii::t(Messages::class . '.crud', $message));
        }
    }

    protected function error($message): void
    {
        if (!Yii::$app->request->getIsAjax()) {
            Yii::app()->user->setFlash($this->flashError, Yii::t(Messages::class . '.crud', $message));
        } else {
            throw new CHttpException(400, $message);
        }
    }

    protected function redirectToView(CActiveRecord $model): void
    {
        if (!Yii::$app->request->getIsAjax()) {
            $this->controller->redirect(['view', 'id' => $model->getPrimaryKey()]);
        }
    }

    protected function redirectToReferrer(): void
    {
        if (!Yii::$app->request->getIsAjax()) {
            $this->controller->redirect(Yii::$app->request->post('returnUrl', ['index']));
        }
    }

    protected function createModel(): CActiveRecord
    {
        $this->checkMethodExists('createModel');
        return $this->controller->createModel();
    }

    protected function loadModel(): CActiveRecord
    {
        $this->checkMethodExists('loadModel');
        $id = Yii::$app->request->get('id');
        return $this->controller->loadModel($id);
    }

    protected function getIndexProviderModel(): CActiveRecord
    {
        $this->checkMethodExists('getIndexProviderModel');
        return $this->controller->getIndexProviderModel();
    }

    protected function checkMethodExists($method): void
    {
        if (!method_exists($this->controller, $method)) {
            throw new CException("Method CController::{$method}() not found");
        }
    }
}
