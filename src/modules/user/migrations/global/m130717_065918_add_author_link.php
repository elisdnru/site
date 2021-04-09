<?php

use yii\db\Migration;

class m130717_065918_add_author_link extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('{{user}}', 'googleplus');
        return true;
    }
}
