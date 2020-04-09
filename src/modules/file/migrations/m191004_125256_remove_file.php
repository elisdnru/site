<?php

use yii\db\Migration;

class m191004_125256_remove_file extends Migration
{
    public function safeUp()
    {
        $this->dropTable('{{file}}');
    }

    public function safeDown()
    {
        $this->createTable('{{file}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'material_id' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'file' => 'varchar(255) NOT NULL',
            'type' => 'varchar(64) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('material_id', '{{file}}', 'material_id');
    }
}
