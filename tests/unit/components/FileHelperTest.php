<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FileHelper;
use Codeception\Test\Unit;

class FileHelperTest extends Unit
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngф_айл.exe', FileHelper::escape('../wro-ng/ф_айл.exe'));
    }
}
