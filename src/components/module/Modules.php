<?php

declare(strict_types=1);

namespace app\components\module;

use OutOfBoundsException;
use yii\base\Application;
use yii\base\Module;

class Modules
{
    private Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     * @psalm-return array<string, array>
     */
    public function definitions(): array
    {
        /** @psalm-var array<string, array> */
        return $this->app->getModules();
    }

    public function load(string $id): Module
    {
        return $this->app->getModule($id) ?: throw new OutOfBoundsException('Undefined module ' . $id);
    }
}
