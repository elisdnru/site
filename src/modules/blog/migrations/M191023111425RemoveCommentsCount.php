<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M191023111425RemoveCommentsCount extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'comments_count');
        $this->dropColumn('blog_posts', 'comments_new_count');
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
