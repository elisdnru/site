<?php

namespace app\components\module;

use CBehavior;
use CConsoleApplication;
use Yii;

class ModuleUrlRulesBehavior extends CBehavior
{
    public $beforeCurrentModule = [];
    public $afterCurrentModule = [];

    public function events()
    {
        return array_merge(parent::events(), [
            'onBeginRequest' => 'beginRequest',
        ]);
    }

    public function beginRequest($event)
    {
        Yii::app()->moduleManager->init();

        if (Yii::app() instanceof CConsoleApplication) {
            return;
        }

        $module = $this->_getCurrentModuleName();

        $list = array_merge(
            $this->beforeCurrentModule,
            [$module],
            $this->afterCurrentModule
        );

        foreach ($list as $name) {
            UrlRulesHelper::import($name);
        }
    }

    protected function _getCurrentModuleName()
    {
        $route = Yii::app()->getRequest()->getPathInfo();
        $domains = explode('/', $route);
        $moduleName = array_shift($domains);
        return $moduleName;
    }
}
