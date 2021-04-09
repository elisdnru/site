<?php

use yii\db\Migration;

class m201213_171236_add_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('portfolio_categories', 'parent_id', 'int(11) DEFAULT NULL');

        $this->update('portfolio_categories', ['parent_id' => null], ['parent_id' => 0]);
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
