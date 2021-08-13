<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M191020153212RemoveKeywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'keywords');
        $this->dropColumn('blog_categories', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('blog_posts', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('blog_categories', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
