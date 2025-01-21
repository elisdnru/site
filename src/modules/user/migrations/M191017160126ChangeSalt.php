<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191017160126ChangeSalt extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) NOT NULL');
        return true;
    }
}
