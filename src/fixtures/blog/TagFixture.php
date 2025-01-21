<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\modules\blog\models\Tag;
use yii\test\ActiveFixture;

/**
 * @psalm-api
 */
final class TagFixture extends ActiveFixture
{
    public $modelClass = Tag::class;
    public $dataFile = __DIR__ . '/data/tag.php';
}
