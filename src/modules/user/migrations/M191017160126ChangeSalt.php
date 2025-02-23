<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191017160126ChangeSalt extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) NOT NULL');
        return true;
    }
}
