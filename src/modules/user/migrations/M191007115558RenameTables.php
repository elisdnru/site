<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

final class M191007115558RenameTables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{user}}', 'users');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('users', '{{user}}');
        return true;
    }
}
