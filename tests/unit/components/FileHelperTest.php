<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FileHelper;
use CTestCase;

class FileHelperTest extends CTestCase
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngf_ajl.exe', FileHelper::escape('../wro-ng/ф_айл.exe'));
    }
}
