<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M190918193620AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
        return true;
    }
}
