<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191010181652AddStyles extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->addColumn('pages', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropColumn('pages', 'styles');
        return true;
    }
}
