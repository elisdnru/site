<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

final class M220605171323RemovePurified extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'text_purified');

        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('pages', 'text_purified', 'mediumtext NOT NULL');

        return true;
    }
}
