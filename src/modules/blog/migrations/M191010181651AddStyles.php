<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191010181651AddStyles extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->addColumn('blog_posts', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropColumn('blog_posts', 'styles');
        return true;
    }
}
