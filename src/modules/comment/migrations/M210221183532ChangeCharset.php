<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M210221183532ChangeCharset extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->execute('ALTER TABLE comments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->execute('ALTER TABLE comments CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
        return true;
    }
}
