<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605171322RemovePurified extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('comments', 'text_purified');

        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('comments', 'text_purified', 'text NOT NULL');

        return true;
    }
}
