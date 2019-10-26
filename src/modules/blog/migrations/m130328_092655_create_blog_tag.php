<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m130328_092655_create_blog_tag extends EDbMigration
{
    public function safeUp()
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
    }

    public function safeDown()
    {
        $this->dropTable('{{blog_post_tag}}');
        $this->dropTable('{{blog_tag}}');
    }
}
