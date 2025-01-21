<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605171321RemovePurified extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'short_purified');
        $this->dropColumn('blog_posts', 'text_purified');

        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('blog_posts', 'short_purified', 'text NOT NULL');
        $this->addColumn('blog_posts', 'text_purified', 'mediumtext NOT NULL');

        return true;
    }
}
