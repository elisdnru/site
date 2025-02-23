<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191023111425RemoveCommentsCount extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'comments_count');
        $this->dropColumn('blog_posts', 'comments_new_count');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
