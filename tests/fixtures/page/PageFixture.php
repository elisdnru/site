<?php

declare(strict_types=1);

namespace tests\fixtures\page;

use yii\test\ActiveFixture;

class PageFixture extends ActiveFixture
{
    public $modelClass = Page::class;
    public $dataFile = __DIR__ . '/../../_data/fixtures/pages.php';
}