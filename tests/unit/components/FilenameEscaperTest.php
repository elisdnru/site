<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FilenameEscaper;
use Codeception\Test\Unit;

/**
 * @internal
 */
final class FilenameEscaperTest extends Unit
{
    public function testThumbFileName(): void
    {
        self::assertEquals('_/wro-ng/ф_айл.exe', FilenameEscaper::escape('../wro-ng/ф_айл.exe'));
    }
}
