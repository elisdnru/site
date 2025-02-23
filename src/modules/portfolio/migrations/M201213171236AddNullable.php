<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201213171236AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('portfolio_categories', 'parent_id', 'int(11) DEFAULT NULL');

        $this->update('portfolio_categories', ['parent_id' => null], ['parent_id' => 0]);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
