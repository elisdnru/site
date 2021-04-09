<?php

use yii\db\Migration;

class m191020_153213_remove_keywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('pages', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
