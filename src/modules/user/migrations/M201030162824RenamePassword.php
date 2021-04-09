<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

class M201030162824RenamePassword extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('users', 'password', 'password_hash');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('users', 'password_hash', 'password');
        return true;
    }
}
