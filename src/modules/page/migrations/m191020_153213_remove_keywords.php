<?php

use yii\db\Migration;

class m191020_153213_remove_keywords extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('pages', 'keywords');
    }

    public function safeDown()
    {
        $this->addColumn('pages', 'keywords', 'varchar(255) DEFAULT NULL');
    }
}
