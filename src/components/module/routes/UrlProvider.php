<?php

declare(strict_types=1);

namespace app\components\module\routes;

interface UrlProvider
{
    public static function rules(): array;

    public static function rulesPriority(): int;
}
