<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use yii\db\Migration;

final class M180806105836RemoveLanguageTables extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('{{portfolio_work_lang}}');
        $this->dropTable('{{portfolio_category_lang}}');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105836_remove_language_tables does not support migration down.\n";
        return false;
    }
}
