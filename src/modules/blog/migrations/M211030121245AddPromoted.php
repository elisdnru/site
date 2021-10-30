<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M211030121245AddPromoted extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('blog_posts', 'promoted', 'tinyint(1) NOT NULL DEFAULT 0');
        $this->createIndex('promoted', 'blog_posts', 'promoted');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('promoted', 'blog_posts');
        $this->dropColumn('blog_posts', 'promoted');
        return true;
    }
}
