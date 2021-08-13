<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use yii\db\Migration;

final class M201213171236AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('portfolio_categories', 'parent_id', 'int(11) DEFAULT NULL');

        $this->update('portfolio_categories', ['parent_id' => null], ['parent_id' => 0]);
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
