<?php

namespace app\components\module\routes;

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

        $sets = [];

        foreach (Yii::app()->getModules() as $name => $definition) {
            if (($set = $this->getRouteSet($name, $definition)) !== []) {
                $sets[] = $set;
            }
        }

        usort($sets, static function (array $a, array $b) {
            return $b['priority'] <=> $a['priority'];
        });

        $urlManager = Yii::app()->getUrlManager();

        foreach ($sets as $set) {
            $urlManager->addRules($set['routes']);
        }
    }

    private function getRouteSet(string $name, array $definition): array
    {
        if (!$class = $definition['class'] ?? null) {
            throw new \RuntimeException('Undefined class for module ' . $name);
        }

        if (!is_subclass_of($class, UrlProvider::class)) {
            return [];
        }

        return [
            'priority' => $class::rulesPriority(),
            'routes' => $class::rules(),
        ];
    }
}