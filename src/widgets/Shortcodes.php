<?php

declare(strict_types=1);

namespace app\widgets;

use app\components\WidgetShortcodes;
use yii\base\Widget;

final class Shortcodes extends Widget
{
    private WidgetShortcodes $shortcodes;

    public function __construct(WidgetShortcodes $shortcodes, array $config = [])
    {
        parent::__construct($config);
        $this->shortcodes = $shortcodes;
    }

    public function init(): void
    {
        parent::init();
        ob_start();
    }

    public function run(): string
    {
        return $this->shortcodes->process(ob_get_clean());
    }
}
