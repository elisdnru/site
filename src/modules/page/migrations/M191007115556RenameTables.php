<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191007115556RenameTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameTable('{{page}}', 'pages');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameTable('pages', '{{page}}');
        return true;
    }
}
