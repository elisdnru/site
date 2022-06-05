<?php

declare(strict_types=1);

namespace app\components\purifier;

use yii\base\Widget;

final class MarkdownWidget extends Widget
{
    private Markdown $markdown;

    public function __construct(Markdown $markdown, array $config = [])
    {
        parent::__construct($config);
        $this->markdown = $markdown;
    }

    public function init(): void
    {
        parent::init();
        ob_start();
    }

    public function run(): string
    {
        $text = trim(ob_get_clean());

        return $this->markdown->transform($text);
    }
}
