<?php

declare(strict_types=1);

namespace app\modules\comment\components;

use Override;
use yii\base\Widget;

final class CommentPostFilterWidget extends Widget
{
    private CommentPostFilter $filter;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(CommentPostFilter $filter, array $config = [])
    {
        parent::__construct($config);
        $this->filter = $filter;
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

        return $this->filter->fixMarkup($text);
    }
}
