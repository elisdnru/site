<?php

use yii\db\Migration;

class m130328_092321_create_blog_post_group extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{blog_post_group}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('{{blog_post_group}}');
        return true;
    }
}
