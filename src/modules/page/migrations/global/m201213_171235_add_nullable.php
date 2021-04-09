<?php

use yii\db\Migration;

class m201213_171235_add_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('pages', 'parent_id', 'int(11) DEFAULT NULL');

        $this->update('pages', ['parent_id' => null], ['parent_id' => 0]);
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
