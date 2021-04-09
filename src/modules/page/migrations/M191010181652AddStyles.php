<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

class M191010181652AddStyles extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('pages', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('pages', 'styles');
        return true;
    }
}
