<?php

declare(strict_types=1);

namespace app\commands\minimize;

interface Driver
{
    public function load($source);

    public function save($target, $content);
}
