<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328094620CreateComment extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('{{comment}}', [
            'id' => 'int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'type' => 'varchar(64) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'material_id' => 'int(11) NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) NOT NULL',
            'site' => 'varchar(255) NOT NULL',
            'text' => 'text NOT NULL',
            'text_purified' => 'text NOT NULL',
            'date' => 'datetime NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
            'public' => 'smallint(1) NOT NULL',
            'moder' => 'smallint(1) NOT NULL DEFAULT 0',
            'likes' => 'int(11) NOT NULL DEFAULT 0',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('material_id', '{{comment}}', 'material_id');
        $this->createIndex('user_id', '{{comment}}', 'user_id');
        $this->createIndex('parent_id', '{{comment}}', 'parent_id');

        $this->createIndex('type', '{{comment}}', 'type');
        $this->createIndex('date', '{{comment}}', 'date');
        $this->createIndex('public', '{{comment}}', 'public');
        $this->createIndex('moder', '{{comment}}', 'moder');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropTable('{{comment}}');
        return true;
    }
}
