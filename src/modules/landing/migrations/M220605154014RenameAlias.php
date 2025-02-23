<?php

declare(strict_types=1);

namespace app\modules\landing\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605154014RenameAlias extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropIndex('landings_alias', 'landings');
        $this->renameColumn('landings', 'alias', 'slug');
        $this->createIndex('landings_slug', 'landings', 'slug', true);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropIndex('landings_slug', 'landings');
        $this->renameColumn('landings', 'slug', 'alias');
        $this->createIndex('landings_alias', 'landings', 'alias', true);
        return true;
    }
}
