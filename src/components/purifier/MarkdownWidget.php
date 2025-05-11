<?php

declare(strict_types=1);

namespace app\components\purifier;

use Override;
use yii\base\Widget;

final class MarkdownWidget extends Widget
{
    private Markdown $markdown;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(Markdown $markdown, array $config = [])
    {
        parent::__construct($config);
        $this->markdown = $markdown;
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
        $text = trim(ob_get_clean());

        return $this->markdown->transform($text);
    }
}
