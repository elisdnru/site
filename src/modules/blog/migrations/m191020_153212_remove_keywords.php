<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191020_153212_remove_keywords extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('blog_posts', 'keywords');
        $this->dropColumn('blog_categories', 'keywords');
    }

    public function safeDown()
    {
        $this->addColumn('blog_posts', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('blog_categories', 'keywords', 'varchar(255) DEFAULT NULL');
    }
}
