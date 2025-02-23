<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M201213171235AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('pages', 'parent_id', 'int(11) DEFAULT NULL');

        $this->update('pages', ['parent_id' => null], ['parent_id' => 0]);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
