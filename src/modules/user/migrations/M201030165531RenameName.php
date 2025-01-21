<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201030165531RenameName extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('users', 'name', 'firstname');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('users', 'firstname', 'name');
        return true;
    }
}
