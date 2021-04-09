<?php

declare(strict_types=1);

namespace app\modules\block\migrations;

use yii\db\Migration;

class M191007115551RenameTables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{block}}', 'blocks');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('blocks', '{{block}}');
        return true;
    }
}
