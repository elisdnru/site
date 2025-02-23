<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191007115553RenameTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameTable('{{comment}}', 'comments');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameTable('comments', '{{comment}}');
        return true;
    }
}
