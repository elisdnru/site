<?php

Yii::import('application.modules.user.components.*');
Yii::import('application.modules.user.models.*');
DUrlRulesHelper::import('user');

class DefaultController extends DController
{
    public function filters()
    {
        return array();
    }

    protected function beforeAction($action)
    {
        if (Yii::app()->config->has('GENERAL.SITE_NAME'))
            throw new CHttpException(404, 'Not found');

        Yii::app()->setTheme('');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionRegister()
    {
        $user = new User(User::SCENARIO_ADMIN_CREATE);
        if (isset($_POST['User']))
        {
            $user->attributes = $_POST['User'];
            $user->role = Access::ROLE_ADMIN;
            $user->active = 1;

            if ($user->save())
            {
                Yii::app()->user->setFlash('success','Регистрация завершена');
                $this->redirect(array('index'));
            }
        }

        $this->render('register', array(
            'model'=>$user,
        ));
    }

    public function actionModules()
	{
        if (count(Yii::app()->modules))
        {
            foreach (Yii::app()->modules as $key => $value)
            {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);

                if ($module)
                {
                    if (is_a($module, 'DWebModule'))
                    {
                        Yii::app()->moduleManager->install($module->id);
                    }
                }
            }
        }

        $this->redirect(array('index'));
	}
}