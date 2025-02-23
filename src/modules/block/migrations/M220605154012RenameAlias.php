<?php

declare(strict_types=1);

namespace app\modules\block\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605154012RenameAlias extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropIndex('alias', 'blocks');
        $this->renameColumn('blocks', 'alias', 'slug');
        $this->createIndex('slug', 'blocks', 'slug', true);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'blocks');
        $this->renameColumn('blocks', 'slug', 'alias');
        $this->createIndex('alias', 'blocks', 'alias', true);
        return true;
    }
}
