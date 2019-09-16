<?php

declare(strict_types=1);

namespace app\commands\minimize;

interface TextProcessor
{
    public function process($text);
}
