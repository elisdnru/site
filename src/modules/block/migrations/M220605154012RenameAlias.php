<?php

declare(strict_types=1);

namespace app\modules\block\migrations;

use yii\db\Migration;

final class M220605154012RenameAlias extends Migration
{
    public function safeUp(): bool
    {
        $this->dropIndex('alias', 'blocks');
        $this->renameColumn('blocks', 'alias', 'slug');
        $this->createIndex('slug', 'blocks', 'slug', true);
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'blocks');
        $this->renameColumn('blocks', 'slug', 'alias');
        $this->createIndex('alias', 'blocks', 'alias', true);
        return true;
    }
}
