<?php

namespace app\components\module;

use CBehavior;
use CConsoleApplication;
use Yii;

class ModuleUrlRulesBehavior extends CBehavior
{
    public $modules = [];

    public function events(): array
    {
        return [
            'onBeginRequest' => 'beginRequest',
        ];
    }

    public function beginRequest(): void
    {
        if (Yii::app() instanceof CConsoleApplication) {
            return;
        }

        $urlManager = Yii::app()->getUrlManager();

        foreach ($this->modules as $name) {
            $urlManager->addRules($this->getRoutes($name));
        }
    }

    private function getRoutes(string $name): array
    {
        if (!Yii::app()->hasModule($name)) {
            throw new \InvalidArgumentException('Undefined module ' . $name);
        }

        if (!$class = Yii::app()->modules[$name]['class'] ?? null) {
            throw new \RuntimeException('Undefined class for module ' . $name);
        }

        if (!method_exists($class, 'rules')) {
            throw new \InvalidArgumentException('Unsupported module ' . $name);
        }

        return $class::rules();
    }
}
