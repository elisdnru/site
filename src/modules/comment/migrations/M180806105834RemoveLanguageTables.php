<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M180806105834RemoveLanguageTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('{{comment}}', 'lang_id');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        echo "m180806_105834_remove_language_tables does not support migration down.\n";
        return false;
    }
}
