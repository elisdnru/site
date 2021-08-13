<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

final class M191007115556RenameTables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{page}}', 'pages');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('pages', '{{page}}');
        return true;
    }
}
