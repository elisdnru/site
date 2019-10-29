<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191020_153214_remove_keywords extends Migration
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
