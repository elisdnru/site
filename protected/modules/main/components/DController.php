<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
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
class DController extends Controller
{
    public $admin = array();
    public $info = '';

    public $isHomePage = false;

    public $description = '';
    public $keywords = '';

    public function filters()
    {
        return array(
            array('application.modules.module.components.DModuleFilter')
        );
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), array(
            'DModuleAccessBehavior'=>array('class'=>'application.modules.module.components.DModuleAccessBehavior'),
            'DUserBehavior'=>array('class'=>'DUserBehavior'),
            'DFlashSessionBehavior'=>array('class'=>'DFlashSessionBehavior'),
            'DLiveLayoutBehavior'=>array('class'=>'DLiveLayoutBehavior'),
            'DJsInitBehavior'=>array('class'=>'DJsInitBehavior'),
            'DInlineWidgetsBehavior'=>array(
                'class'=>'DInlineWidgetsBehavior',
                'location'=>'application.widgets',
                'widgets'=>Yii::app()->params['runtimeWidgets'],
                'classSuffix'=> 'Widget',
                'startBlock'=> '[{widget:',
                'endBlock'=> '}]',
            ),
        ));
    }

    public function init()
    {
        $this->initFlashSession();
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
        if (!Yii::app()->request->isPostRequest)
            throw new CHttpException (400, 'Bad request');
    }

    public function refresh($terminate=true, $anchor='')
    {
        $this->redirect(Yii::app()->getRequest()->getOriginalUrl() . $anchor, $terminate);
    }

    public function redirectOrAjax($route = array('index'))
    {
        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $route);
    }

    public function checkUrl($url)
    {
        if ('/' . Yii::app()->getRequest()->getPathInfo() != $url)
            $this->redirect($url, true, 301);
    }

    public function reflash()
    {
        foreach (array('notice', 'success', 'error') as $type)
        {
            if(Yii::app()->user->hasFlash($type))
                Yii::app()->user->setFlash($type, Yii::app()->user->getFlash($type));
        }
    }
}