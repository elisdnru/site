<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M191010181651AddStyles extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('blog_posts', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('blog_posts', 'styles');
        return true;
    }
}
