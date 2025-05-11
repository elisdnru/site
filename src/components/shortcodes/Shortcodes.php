<?php

declare(strict_types=1);

namespace app\components\shortcodes;

use Override;
use yii\base\Widget;

final class Shortcodes extends Widget
{
    private ShortcodesProcessor $shortcodes;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(ShortcodesProcessor $shortcodes, array $config = [])
    {
        parent::__construct($config);
        $this->shortcodes = $shortcodes;
    }

    #[Override]
    public function init(): void
    {
        parent::init();
        ob_start();
    }

    #[Override]
    public function run(): string
    {
        return $this->shortcodes->process(ob_get_clean()) ?? '';
    }
}
