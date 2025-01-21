<?php

declare(strict_types=1);

namespace tests\unit\components;

use app\components\FilenameEscaper;
use Codeception\Test\Unit;

/**
 * @psalm-api
 * @internal
 */
final class FilenameEscaperTest extends Unit
{
    public function testEscapeFile(): void
    {
        self::assertEquals('w_._.r._.o-ng_f_ajl.exe', FilenameEscaper::escapeFile('../w/./...r.' . "\t" . '.o-ng/ф_айл.exe'));
    }

    public function testEscapePath(): void
    {
        self::assertEquals('w.r._.o-ng/f_ajl.exe', FilenameEscaper::escapePath('./../w...r.' . "\t" . '.o-ng/ф_айл.exe/./'));
    }
}
