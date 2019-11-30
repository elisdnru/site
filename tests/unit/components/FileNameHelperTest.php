<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FileNameFilter;
use Codeception\Test\Unit;

class FileNameHelperTest extends Unit
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngф_айл.exe', FileNameFilter::escape('../wro-ng/ф_айл.exe'));
    }
}
