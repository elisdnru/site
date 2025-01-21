<?php

declare(strict_types=1);

namespace app\modules\block\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M180806105832RemoveLanguageTables extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('{{block_lang}}');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105832_remove_language_tables does not support migration down.\n";
        return false;
    }
}
