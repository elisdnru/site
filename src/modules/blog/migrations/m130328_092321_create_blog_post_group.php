<?php

class m130328_092321_create_blog_post_group extends EDbMigration
{
	public function safeUp()
	{
        $this->createTable('{{blog_post_group}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function safeDown()
	{
        $this->dropTable('{{blog_post_group}}');
	}
}