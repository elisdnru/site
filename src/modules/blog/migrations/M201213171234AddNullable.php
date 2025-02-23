<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201213171234AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('blog_categories', 'parent_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'group_id', 'int(11) DEFAULT NULL');

        $this->update('blog_categories', ['parent_id' => null], ['parent_id' => 0]);
        $this->update('blog_posts', ['group_id' => null], ['group_id' => 0]);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
