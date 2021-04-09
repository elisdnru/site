<?php

use yii\db\Migration;

class m130328_092655_create_blog_tag extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{blog_tag}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('{{blog_post_tag}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'post_id' => 'int(11) NOT NULL',
            'tag_id' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('post_id', '{{blog_post_tag}}', 'post_id');
        $this->createIndex('tag_id', '{{blog_post_tag}}', 'tag_id');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('{{blog_post_tag}}');
        $this->dropTable('{{blog_tag}}');
        return true;
    }
}
