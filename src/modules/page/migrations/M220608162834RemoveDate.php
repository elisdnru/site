<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

final class M220608162834RemoveDate extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'date');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('pages', 'date', 'date NOT NULL');
        return true;
    }
}
