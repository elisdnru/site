<?php

namespace app\components;

use app\components\behaviors\InlineWidgetsBehavior;
use CController;
use CHttpException;
use Yii;

/**
 * @property InlineWidgetsBehavior $InlineWidgetsBehavior
 * @method string decodeWidgets($text)
 * @method string clearWidgets($text)
 */
class Controller extends CController
{
    public $title = '';
    public $params = [];

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'InlineWidgetsBehavior' => [
                'class' => behaviors\InlineWidgetsBehavior::class,
                'widgets' => Yii::app()->params['runtimeWidgets'],
            ],
        ]);
    }

    protected function beforeAction($action)
    {
        Yii::$app->controller = $this;
        return parent::beforeAction($action);
    }

    public function checkIsPost(): void
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400, 'Bad request');
        }
    }

    public function refresh($terminate = true, $anchor = ''): void
    {
        $this->redirect(Yii::app()->getRequest()->getUrl() . $anchor, $terminate);
    }

    public function redirectOrAjax($route = ['index']): void
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect($_POST['returnUrl'] ?? $route);
        }
    }

    public function checkUrl($url): void
    {
        if ('/' . Yii::app()->getRequest()->getPathInfo() !== $url) {
            $this->redirect($url, true, 301);
        }
    }

    public function reflash(): void
    {
        foreach (['notice', 'success', 'error'] as $type) {
            if (Yii::app()->user->hasFlash($type)) {
                Yii::app()->user->setFlash($type, Yii::app()->user->getFlash($type));
            }
        }
    }
}
