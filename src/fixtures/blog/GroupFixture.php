<?php

declare(strict_types=1);

namespace app\fixtures\blog;

use app\modules\blog\models\Group;
use yii\test\ActiveFixture;

/**
 * @psalm-api
 */
final class GroupFixture extends ActiveFixture
{
    public $modelClass = Group::class;
    public $dataFile = __DIR__ . '/data/group.php';
}
