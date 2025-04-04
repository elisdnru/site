<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M180806105833RemoveLanguageTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropTable('{{blog_post_lang}}');
        $this->dropTable('{{blog_category_lang}}');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        echo "m180806_105833_remove_language_tables does not support migration down.\n";
        return false;
    }
}
