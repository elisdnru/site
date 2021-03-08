<?php

use yii\db\Migration;

class m191020_153214_remove_keywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('portfolio_works', 'keywords');
        $this->dropColumn('portfolio_categories', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('portfolio_works', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('portfolio_categories', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
