<?php

namespace app\components;

use CController;
use CHttpException;
use app\modules\user\models\User;
use Yii;

/**
 *
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * ModuleAccessBehavior
 * @method boolean moduleAllowed($module)
 *
 * UserBehavior
 * @method User getUser()
 * @method boolean is($role)
 * @method check($role)
 *
 * LiveLayoutBehavior
 * @method initLayout()
 *
 * JsInitBehavior
 * @method initJsDefaults()
 *
 * InlineWidgetsBehavior
 * @method string decodeWidgets($text)
 * @method string clearWidgets($text)
 */
class Controller extends CController
{
    public $menu = [];
    public $breadcrumbs = [];

    public $admin = [];

    public $description = '';
    public $keywords = '';

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'ModuleAccessBehavior' => ['class' => \app\components\module\ModuleAccessBehavior::class],
            'UserBehavior' => ['class' => behaviors\UserBehavior::class],
            'JsInitBehavior' => ['class' => behaviors\JsInitBehavior::class],
            'InlineWidgetsBehavior' => [
                'class' => behaviors\InlineWidgetsBehavior::class,
                'location' => 'application.widgets',
                'widgets' => Yii::app()->params['runtimeWidgets'],
                'classSuffix' => 'Widget',
                'startBlock' => '[{widget:',
                'endBlock' => '}]',
            ],
        ]);
    }

    protected function beforeRender($viev): bool
    {
        $this->initJsDefaults();
        return parent::beforeRender($viev);
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
