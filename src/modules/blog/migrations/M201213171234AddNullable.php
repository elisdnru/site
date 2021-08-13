<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M201213171234AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('blog_categories', 'parent_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'group_id', 'int(11) DEFAULT NULL');

        $this->update('blog_categories', ['parent_id' => null], ['parent_id' => 0]);
        $this->update('blog_posts', ['group_id' => null], ['group_id' => 0]);
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
