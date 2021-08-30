<?php

declare(strict_types=1);

namespace app\components\feature;

use yii\base\Application;
use yii\base\Behavior;
use yii\base\Event;

final class FeaturesNegotiator extends Behavior
{
    private FeatureToggle $features;

    public function __construct(FeatureToggle $features, array $config = [])
    {
        parent::__construct($config);
        $this->features = $features;
    }

    public function events(): array
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest',
        ];
    }

    public function beforeRequest(Event $event): void
    {
        $app = $event->sender;

        if (!$app instanceof \yii\web\Application) {
            return;
        }

        $features = preg_split('/\s*,\s*/', (string)($_COOKIE['features'] ?? ''));

        foreach ($features as $name) {
            if (str_starts_with($name, '!')) {
                $this->features->deactivate(substr($name, 1));
            } else {
                $this->features->activate($name);
            }
        }
    }
}
