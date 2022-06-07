<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M220607173423AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('blog_posts', 'image', 'varchar(255) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('blog_posts', 'image', 'varchar(255) NOT NULL');
        return true;
    }
}
