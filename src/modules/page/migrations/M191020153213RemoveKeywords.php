<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191020153213RemoveKeywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('pages', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
