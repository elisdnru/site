<?php

namespace app\components\module\routes;

use RuntimeException;
use yii\base\BootstrapInterface;
use yii\web\Application;

class RoutesLoader implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        if (!$app instanceof Application) {
            return;
        }

        $sets = [];

        /**
         * @var string $name
         * @var array $definition
         */
        foreach ($app->getModules() as $name => $definition) {
            if (($set = $this->getRouteSet($name, $definition)) !== []) {
                $sets[] = $set;
            }
        }

        usort($sets, static function (array $a, array $b) {
            return $b['priority'] <=> $a['priority'];
        });

        $urlManager = $app->getUrlManager();

        foreach ($sets as $set) {
            $urlManager->addRules($set['routes']);
        }
    }

    private function getRouteSet(string $name, array $definition): array
    {
        if (!$class = $definition['class'] ?? null) {
            throw new RuntimeException('Undefined class for module ' . $name);
        }

        if (!is_subclass_of($class, RoutesProvider::class)) {
            return [];
        }

        return [
            'priority' => $class::routesPriority(),
            'routes' => $class::routes(),
        ];
    }
}
