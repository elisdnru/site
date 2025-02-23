<?php

declare(strict_types=1);

namespace app\modules\block\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191007115551RenameTables extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameTable('{{block}}', 'blocks');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameTable('blocks', '{{block}}');
        return true;
    }
}
