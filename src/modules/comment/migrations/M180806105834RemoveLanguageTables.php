<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use yii\db\Migration;

final class M180806105834RemoveLanguageTables extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('{{comment}}', 'lang_id');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105834_remove_language_tables does not support migration down.\n";
        return false;
    }
}
