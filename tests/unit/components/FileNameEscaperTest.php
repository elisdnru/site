<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FileNameEscaper;
use Codeception\Test\Unit;

class FileNameEscaperTest extends Unit
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngф_айл.exe', FileNameEscaper::escape('../wro-ng/ф_айл.exe'));
    }
}
