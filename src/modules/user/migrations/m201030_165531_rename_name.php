<?php

use yii\db\Migration;

class m201030_165531_rename_name extends Migration
{
    /**
     * @var int|null
     */
    public $maxSqlOutputLength = null;

    public function safeUp()
    {
        $this->renameColumn('users', 'name', 'firstname');

        return true;
    }

    public function safeDown()
    {
        $this->renameColumn('users', 'firstname', 'name');

        return true;
    }
}