<?php

declare(strict_types=1);

namespace app\components;

interface Logger
{
    public function writeln($message = '');

    public function write($message);

    public function writelnSuccess($message = 'OK');

    public function writeSuccess($message = 'OK');

    public function writelnError($message = 'FAIL');

    public function writeError($message = 'FAIL');

    public function writelnNotice($message);

    public function writeNotice($message);
}
