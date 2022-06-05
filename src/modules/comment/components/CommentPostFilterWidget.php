<?php

declare(strict_types=1);

namespace app\modules\comment\components;

use yii\base\Widget;

final class CommentPostFilterWidget extends Widget
{
    private CommentPostFilter $filter;

    public function __construct(CommentPostFilter $filter, array $config = [])
    {
        parent::__construct($config);
        $this->filter = $filter;
    }

    public function init(): void
    {
        parent::init();
        ob_start();
    }

    public function run(): string
    {
        $text = trim(ob_get_clean());

        return $this->filter->fixMarkup($text);
    }
}
