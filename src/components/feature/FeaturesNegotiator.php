<?php

declare(strict_types=1);

namespace app\components\feature;

use Override;
use yii\base\Application;
use yii\base\Behavior;
use yii\base\Event;

final class FeaturesNegotiator extends Behavior
{
    private FeatureToggle $features;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(FeatureToggle $features, array $config = [])
    {
        parent::__construct($config);
        $this->features = $features;
    }

    #[Override]
    public function events(): array
    {
        return [
            Application::EVENT_BEFORE_REQUEST => $this->beforeRequest(...),
        ];
    }

    private function beforeRequest(Event $event): void
    {
        $app = $event->sender;

        if (!$app instanceof \yii\web\Application) {
            return;
        }

        $features = preg_split('/\s*,\s*/', $_COOKIE['features'] ?? '');

        foreach ($features as $name) {
            if (str_starts_with($name, '!')) {
                $this->features->deactivate(substr($name, 1));
            } else {
                $this->features->activate($name);
            }
        }
    }
}
