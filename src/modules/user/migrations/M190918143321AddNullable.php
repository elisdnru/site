<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M190918143321AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime NOT NULL');
        return true;
    }
}
