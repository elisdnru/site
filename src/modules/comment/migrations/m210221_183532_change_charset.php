<?php

use yii\db\Migration;

class m210221_183532_change_charset extends Migration
{
    public function safeUp(): bool
    {
        $this->execute('ALTER TABLE comments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        return true;
    }

    public function safeDown(): bool
    {
        $this->execute('ALTER TABLE comments CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
        return true;
    }
}
