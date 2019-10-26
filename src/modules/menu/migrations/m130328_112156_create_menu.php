<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m130328_112156_create_menu extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{menu}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'link' => 'varchar(255) NOT NULL',
            'sort' => 'smallint(3) NOT NULL DEFAULT 0',
            'parent_id' => 'int(11) NOT NULL DEFAULT 0',
            'visible' => 'smallint(1) NOT NULL DEFAULT 1',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('parent_id', '{{menu}}', 'parent_id');

        $this->createIndex('alias', '{{menu}}', 'alias');
        $this->createIndex('sort', '{{menu}}', 'sort');
        $this->createIndex('visible', '{{menu}}', 'visible');

        $this->createTable('{{menu_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{menu_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{menu_lang}}', 'owner_id');
        $this->addForeignKey('menu_lang_owner', '{{menu_lang}}', 'owner_id', '{{menu}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('menu_lang_owner', '{{menu_lang}}');
        $this->dropTable('{{menu_lang}}');
        $this->dropTable('{{menu}}');
    }
}
