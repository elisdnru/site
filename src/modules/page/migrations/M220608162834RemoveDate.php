<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220608162834RemoveDate extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'date');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('pages', 'date', 'date NOT NULL');
        return true;
    }
}
