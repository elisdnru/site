<?php

declare(strict_types=1);

namespace app\fixtures\page;

use app\modules\page\models\Page;
use yii\test\ActiveFixture;

final class PageFixture extends ActiveFixture
{
    public $modelClass = Page::class;
    public $dataFile = __DIR__ . '/data/page.php';
}
