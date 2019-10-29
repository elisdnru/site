<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m130329_081136_create_session extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{session}}', [
            'id' => 'char(32) NOT NULL PRIMARY KEY',
            'expire' => 'int(11) DEFAULT NULL',
            'data' => 'text',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('expire', '{{session}}', 'expire');
    }

    public function safeDown()
    {
        $this->dropTable('{{session}}');
    }
}
