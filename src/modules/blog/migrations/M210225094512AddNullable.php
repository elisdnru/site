<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M210225094512AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) NOT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) NOT NULL');
        return true;
    }
}
