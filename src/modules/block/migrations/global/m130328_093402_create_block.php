<?php

use yii\db\Migration;

class m130328_093402_create_block extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{block}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('alias', '{{block}}', 'alias');

        $this->createTable('{{block_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{block_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{block_lang}}', 'owner_id');

        $this->addForeignKey('block_lang_owner', '{{block_lang}}', 'owner_id', '{{block}}', 'id', 'CASCADE', 'CASCADE');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropForeignKey('block_lang_owner', '{{block_lang}}');

        $this->dropTable('{{block_lang}}');
        $this->dropTable('{{block}}');
        return true;
    }
}