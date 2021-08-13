<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

final class M201030155612RemoveMiddlename extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'middlename');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('{{user}}', 'middlename', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
