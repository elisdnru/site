<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FilenameEscaper;
use Codeception\Test\Unit;

class FilenameEscaperTest extends Unit
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngф_айл.exe', FilenameEscaper::escape('../wro-ng/ф_айл.exe'));
    }
}
