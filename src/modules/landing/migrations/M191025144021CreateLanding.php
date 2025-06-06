<?php

declare(strict_types=1);

namespace app\modules\landing\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191025144021CreateLanding extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('landings', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'system' => 'tinyint(1) NOT NULL',
            'parent_id' => 'int(11) DEFAULT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('landings_alias', 'landings', 'alias');
        $this->createIndex('landings_parent_id', 'landings', 'parent_id');
        $this->addForeignKey('landings_parent', 'landings', 'parent_id', 'landings', 'id');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropForeignKey('landings_parent', 'landings');
        $this->dropTable('landings');
        return true;
    }
}
