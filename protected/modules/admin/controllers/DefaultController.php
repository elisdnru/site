<?php

class DefaultController extends DAdminController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array(Access::ROLE_CONTROL),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

	public function actionIndex()
	{
        if (count(Yii::app()->modules))
        {
            foreach (Yii::app()->modules as $key => $value)
            {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);

                if ($module)
                {
                    if (is_a($module, 'DWebModule') && Yii::app()->moduleManager->active($module->id) && Yii::app()->moduleManager->allowed($module->id))
                    {
                        $modules[isset($module->group) ? $module->group : 'Прочее'][$module->name] = $module;
                    }
                }
            }
        }

        ksort($modules);

		$this->render('index', array(
            'modules'=>$modules,
            'user'=>$this->getUser(),
        ));
	}
}