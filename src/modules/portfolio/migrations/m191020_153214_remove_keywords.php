<?php

use app\extensions\migrate\EDbMigration;

class m191020_153214_remove_keywords extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('portfolio_works', 'keywords');
        $this->dropColumn('portfolio_categories', 'keywords');
    }

    public function safeDown()
    {
        $this->addColumn('portfolio_works', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('portfolio_categories', 'keywords', 'varchar(255) DEFAULT NULL');
    }
}
