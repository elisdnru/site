<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M210225094512AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) NOT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) NOT NULL');
        return true;
    }
}
