<?php

declare(strict_types=1);

namespace tests\unit\components\uploader;

use app\components\uploader\Uploader;
use app\extensions\file\File;
use app\extensions\image\Image;
use Codeception\Test\Unit;

/**
 * @psalm-api
 * @internal
 */
final class UploaderTest extends Unit
{
    public function testThumbFileName(): void
    {
        $manager = new Uploader(new File(), new Image());

        self::assertEquals('ab0cde_250x0.jpg', $manager->createThumbFileName('ab0cde.jpg', 250, 0));
        self::assertEquals('ab0cde_100x100.png', $manager->createThumbFileName('ab0cde.png', 100, 100));
    }
}
