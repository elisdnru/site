<?php

use yii\db\Migration;

class m201030_162824_rename_password extends Migration
{
    /**
     * @var int|null
     */
    public $maxSqlOutputLength = null;

    public function safeUp()
    {
        $this->renameColumn('users', 'password', 'password_hash');

        return true;
    }

    public function safeDown()
    {
        $this->renameColumn('users', 'password_hash', 'password');

        return true;
    }
}
