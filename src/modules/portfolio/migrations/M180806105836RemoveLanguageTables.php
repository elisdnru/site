<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M180806105836RemoveLanguageTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropTable('{{portfolio_work_lang}}');
        $this->dropTable('{{portfolio_category_lang}}');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        echo "m180806_105836_remove_language_tables does not support migration down.\n";
        return false;
    }
}
