<?php

declare(strict_types=1);

namespace tests\unit\modules\uploader\components;

use app\modules\uploader\components\UploadManager;
use CTestCase;

class UploadManagerTest extends CTestCase
{
    public function testOrigFileName(): void
    {
        $manager = new UploadManager();

        self::assertEquals('ab0cde.jpg', $manager->createOrigFileName('ab0cde.jpg'));
    }

    public function testOrigFileNameWithWatermark(): void
    {
        $manager = new UploadManager();
        $manager->origFileSalt = 'salt';
        $manager->watermarkFile = 'watermark.png';

        self::assertEquals('ab0cde_orig_salt.jpg', $manager->createOrigFileName('ab0cde.jpg'));
    }

    public function testThumbFileName(): void
    {
        $manager = new UploadManager();
        $manager->origFileSalt = 'adFxt0de';

        self::assertEquals('ab0cde_250x0.jpg', $manager->createThumbFileName('ab0cde.jpg', 250, 0));
        self::assertEquals('ab0cde_100x100.png', $manager->createThumbFileName('ab0cde.png', 100, 100));
    }
}
