<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191023111426RemoveCommentsCount extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'comments_count');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
