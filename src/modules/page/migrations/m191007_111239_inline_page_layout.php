<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191007_111239_inline_page_layout extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{page}}', 'layout', 'varchar(255) DEFAULT NULL');
        $this->addColumn('{{page}}', 'subpages_layout', 'varchar(255) DEFAULT NULL');

        $this->execute('UPDATE {{page}} AS p SET layout = (SELECT l.alias FROM {{page_layout}} AS l WHERE l.id = p.layout_id)');
        $this->execute('UPDATE {{page}} AS p SET subpages_layout = (SELECT l.alias FROM {{page_layout_subpages}} AS l WHERE l.id = p.layout_subpages_id)');

        $this->alterColumn('{{page}}', 'layout', 'varchar(255) NOT NULL');
        $this->alterColumn('{{page}}', 'subpages_layout', 'varchar(255) NOT NULL');

        $this->dropColumn('{{page}}', 'layout_id');
        $this->dropColumn('{{page}}', 'layout_subpages_id');

        $this->dropTable('{{page_layout}}');
        $this->dropTable('{{page_layout_subpages}}');
    }

    public function safeDown()
    {
        echo "m191007_111239_inline_page_layout does not support migration down.\n";
        return false;
    }
}
