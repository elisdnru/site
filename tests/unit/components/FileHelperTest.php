<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\helpers\FileHelper;
use CTestCase;

class FileHelperTest extends CTestCase
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngф_айл.exe', FileHelper::escape('../wro-ng/ф_айл.exe'));
    }
}
