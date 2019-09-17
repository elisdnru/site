<?php

namespace app\modules\main\components;

use app\components\Controller as BaseController;
use CHttpException;
use app\modules\user\models\User;
use Yii;

/**
 *
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 *
 * DModuleAccessBehavior
 * @method boolean moduleAllowed($module)
 *
 * DUserBehavior
 * @method User getUser()
 * @method boolean is($role)
 * @method check($role)
 *
 * DFlashSessionBehavior
 * @method initFlashSession()
 *
 * DHeadersBehavior
 * @method initHeaders()
 *
 * DLiveLayoutBehavior
 * @method initLayout()
 *
 * DJsInitBehavior
 * @method initJsDefaults()
 *
 * DInlineWidgetsBehavior
 * @method string decodeWidgets($text)
 * @method string clearWidgets($text)
 */
class Controller extends BaseController
{
    public $admin = [];
    public $info = '';

    public $isHomePage = false;

    public $description = '';
    public $keywords = '';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'DModuleAccessBehavior' => ['class' => \app\components\module\ModuleAccessBehavior::class],
            'DUserBehavior' => ['class' => behaviors\UserBehavior::class],
            'DFlashSessionBehavior' => ['class' => behaviors\FlashSessionBehavior::class],
            'DHeadersBehavior' => ['class' => behaviors\HeadersBehavior::class],
            'DLiveLayoutBehavior' => ['class' => behaviors\LiveLayoutBehavior::class],
            'DJsInitBehavior' => ['class' => behaviors\JsInitBehavior::class],
            'DInlineWidgetsBehavior' => [
                'class' => behaviors\InlineWidgetsBehavior::class,
                'location' => 'application.widgets',
                'widgets' => Yii::app()->params['runtimeWidgets'],
                'classSuffix' => 'Widget',
                'startBlock' => '[{widget:',
                'endBlock' => '}]',
            ],
        ]);
    }

    public function init()
    {
        $this->initFlashSession();
        $this->initHeaders();
        parent::init();
    }

    protected function beforeRender($viev)
    {
        $this->initJsDefaults();
        $this->initLayout();
        return parent::beforeRender($viev);
    }

    public function checkIsPost()
    {
        if (!Yii::app()->request->isPostRequest) {
            throw new CHttpException(400, 'Bad request');
        }
    }

    public function refresh($terminate = true, $anchor = '')
    {
        $this->redirect(Yii::app()->getRequest()->getUrl() . $anchor, $terminate);
    }

    public function redirectOrAjax($route = ['index'])
    {
        if (!Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $route);
        }
    }

    public function checkUrl($url)
    {
        if ('/' . Yii::app()->getRequest()->getPathInfo() != $url) {
            $this->redirect($url, true, 301);
        }
    }

    public function reflash()
    {
        foreach (['notice', 'success', 'error'] as $type) {
            if (Yii::app()->user->hasFlash($type)) {
                Yii::app()->user->setFlash($type, Yii::app()->user->getFlash($type));
            }
        }
    }
}
