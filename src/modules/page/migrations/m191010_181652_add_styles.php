<?php

use yii\db\Migration;

class m191010_181652_add_styles extends Migration
{
    public function safeUp()
    {
        $this->addColumn('pages', 'styles', 'TEXT DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('pages', 'styles');
    }
}
