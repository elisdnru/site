<?php

class ModuleAdminController extends DAdminController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'roles'=>array(Access::ROLE_ADMIN),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + install, uninstall, toggleInstalled, toggleActive',
        ));
    }

	public function actionIndex()
	{
        $modules = array();

        if (count(Yii::app()->modules))
        {
            foreach (Yii::app()->modules as $key => $value)
            {
                $key = strtolower($key);
                $module = Yii::app()->getModule($key);

                if ($module)
                {
                    if (is_a($module, 'DWebModule') && !Yii::app()->moduleManager->system($module->id))
                    {
                        $modules[] = array(
                            'id'=>$module->id,
                            'name'=>$module->name,
                            'group'=>$module->group,
                            'installed'=>Yii::app()->moduleManager->installed($module->id),
                            'active'=>Yii::app()->moduleManager->active($module->id),
                        );
                    }
                }
            }
        }

        $dataProvider = new CArrayDataProvider($modules, array(
            'pagination'=>array(
                'pageSize'=>100
            )
        ));

		$this->render('index', array(
            'dataProvider'=>$dataProvider,
        ));
	}

    public function actionInstall($module)
    {
        if (Yii::app()->moduleManager->install($module))
        {
            if (!Yii::app()->request->isAjaxRequest)
                Yii::app()->user->setFlash('success', 'Модуль установлен');
        } else
            throw new CHttpException(400, 'Ошибка установки');

        $this->redirectOrAjax();
    }

    public function actionUninstall($module)
    {
        if (Yii::app()->moduleManager->uninstall($module))
        {
            if (!Yii::app()->request->isAjaxRequest)
                Yii::app()->user->setFlash('success', 'Модуль удалён');
        } else
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }

    public function actionToggleInstalled($module)
    {
        if (Yii::app()->moduleManager->installed($module))
        {
            if (!Yii::app()->moduleManager->system($module) && Yii::app()->moduleManager->uninstall($module))
            {
                if (!Yii::app()->request->isAjaxRequest)
                    Yii::app()->user->setFlash('success', 'Модуль удалён');
            } else
                throw new CHttpException(400, 'Ошибка удаления');
        }
        else
        {
            if (Yii::app()->moduleManager->install($module))
            {
                if (!Yii::app()->request->isAjaxRequest)
                    Yii::app()->user->setFlash('success', 'Модуль установлен');
            } else
                throw new CHttpException(400, 'Ошибка установки');
        }
        $this->redirectOrAjax();
    }

    public function actionToggleActive($module)
    {
        if (Yii::app()->moduleManager->active($module))
        {
            if (!Yii::app()->moduleManager->system($module) && Yii::app()->moduleManager->deactivate($module))
            {
                if (!Yii::app()->request->isAjaxRequest)
                    Yii::app()->user->setFlash('success', 'Модуль отключён');
            } else
                throw new CHttpException(400, 'Ошибка отключеия');
        }
        else
        {
            if (Yii::app()->moduleManager->activate($module))
            {
                if (!Yii::app()->request->isAjaxRequest)
                    Yii::app()->user->setFlash('success', 'Модуль включён');
            } else
                throw new CHttpException(400, 'Ошибка включения');
        }
        $this->redirectOrAjax();
    }
}