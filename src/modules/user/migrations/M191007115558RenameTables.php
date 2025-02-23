<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191007115558RenameTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameTable('{{user}}', 'users');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameTable('users', '{{user}}');
        return true;
    }
}
