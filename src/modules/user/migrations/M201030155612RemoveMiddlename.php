<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201030155612RemoveMiddlename extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'middlename');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('{{user}}', 'middlename', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
