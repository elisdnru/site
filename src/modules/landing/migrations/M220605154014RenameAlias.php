<?php

declare(strict_types=1);

namespace app\modules\landing\migrations;

use yii\db\Migration;

final class M220605154014RenameAlias extends Migration
{
    public function safeUp(): bool
    {
        $this->dropIndex('landings_alias', 'landings');
        $this->renameColumn('landings', 'alias', 'slug');
        $this->createIndex('landings_slug', 'landings', 'slug', true);
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('landings_slug', 'landings');
        $this->renameColumn('landings', 'slug', 'alias');
        $this->createIndex('landings_alias', 'landings', 'alias', true);
        return true;
    }
}
