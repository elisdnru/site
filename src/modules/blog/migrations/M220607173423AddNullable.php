<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220607173423AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('blog_posts', 'image', 'varchar(255) DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->alterColumn('blog_posts', 'image', 'varchar(255) NOT NULL');
        return true;
    }
}
