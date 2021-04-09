<?php

declare(strict_types=1);

namespace app\modules\file\migrations;

use yii\db\Migration;

class M191004125256RemoveFile extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('{{file}}');
        return true;
    }

    public function safeDown(): bool
    {
        $this->createTable('{{file}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'material_id' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'file' => 'varchar(255) NOT NULL',
            'type' => 'varchar(64) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('material_id', '{{file}}', 'material_id');
        return true;
    }
}
