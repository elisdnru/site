<?php

declare(strict_types=1);

namespace app\components\module;

use OutOfBoundsException;
use yii\base\Application;
use yii\base\Module;

/**
 * @psalm-type ModuleDefinition = array{class?: string}
 * @psalm-type ModuleDefinitions = array<string, ModuleDefinition>
 */
class Modules
{
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @psalm-return ModuleDefinitions
     */
    public function definitions(): array
    {
        /** @psalm-var ModuleDefinitions */
        return $this->app->getModules();
    }

    public function load(string $id): Module
    {
        return $this->app->getModule($id) ?: throw new OutOfBoundsException('Undefined module ' . $id);
    }
}
