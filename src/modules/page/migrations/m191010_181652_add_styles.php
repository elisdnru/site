<?php

use yii\db\Migration;

class m191010_181652_add_styles extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('pages', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('pages', 'styles');
        return true;
    }
}
