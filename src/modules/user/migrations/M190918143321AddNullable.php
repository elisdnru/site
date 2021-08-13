<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

final class M190918143321AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime NOT NULL');
        return true;
    }
}
