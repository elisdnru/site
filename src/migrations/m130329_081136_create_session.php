<?php

use yii\db\Migration;

class m130329_081136_create_session extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{session}}', [
            'id' => 'char(32) NOT NULL PRIMARY KEY',
            'expire' => 'int(11) DEFAULT NULL',
            'data' => 'text',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('expire', '{{session}}', 'expire');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('{{session}}');
        return true;
    }
}
