<?php

declare(strict_types=1);

namespace tests\unit\components;

use CTestCase;

class FileHelperTest extends CTestCase
{
    public function testThumbFileName(): void
    {
        self::assertEquals('wro-ngf_ajl.exe', \app\components\helpers\FileHelper::escape('../wro-ng/ф_айл.exe'));
    }
}
