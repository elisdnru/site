<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191023111426RemoveCommentsCount extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'comments_count');
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
