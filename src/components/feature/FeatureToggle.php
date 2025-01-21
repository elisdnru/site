<?php

declare(strict_types=1);

namespace app\components\feature;

final class FeatureToggle
{
    /**
     * @var array<string, bool>
     */
    private array $features;

    /**
     * @psalm-api
     * @param array<string, bool> $features
     */
    public function __construct(array $features)
    {
        $this->features = $features;
    }

    public function activate(string $name): void
    {
        $this->features[$name] = true;
    }

    public function deactivate(string $name): void
    {
        $this->features[$name] = false;
    }

    public function isActive(string $name): bool
    {
        if (!\array_key_exists($name, $this->features)) {
            return false;
        }

        return $this->features[$name];
    }
}
