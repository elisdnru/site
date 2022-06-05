<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M220605150612RemoveImageSize extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'image_width');
        $this->dropColumn('blog_posts', 'image_height');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('blog_posts', 'image_width', 'int(11) DEFAULT NULL');
        $this->addColumn('blog_posts', 'image_height', 'int(11) DEFAULT NULL');
        return true;
    }
}
