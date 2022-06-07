<?php

declare(strict_types=1);

namespace app\modules\landing\migrations;

use yii\db\Migration;

final class M220607183716RemoveUnique extends Migration
{
    public function safeUp(): bool
    {
        $this->dropIndex('landings_slug', 'landings');
        $this->createIndex('landings_slug', 'landings', 'slug');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('landings_slug', 'landings');
        $this->createIndex('landings_slug', 'landings', 'slug', true);
        return true;
    }
}
