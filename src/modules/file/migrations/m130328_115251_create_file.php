<?php

use yii\db\Migration;

class m130328_115251_create_file extends Migration
{
    public function safeUp()
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

    public function safeDown()
    {
        $this->dropTable('{{file}}');
    }
}
