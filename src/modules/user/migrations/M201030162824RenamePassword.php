<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201030162824RenamePassword extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameColumn('users', 'password', 'password_hash');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameColumn('users', 'password_hash', 'password');
        return true;
    }
}
