<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M181022130712RemoveAddress extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('{{user}}', 'zip');
        $this->dropColumn('{{user}}', 'address');
        $this->dropColumn('{{user}}', 'phone');
        $this->dropColumn('{{user}}', 'googleplus');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('{{user}}', 'zip', 'varchar(255) NOT NULL');
        $this->addColumn('{{user}}', 'address', 'text NOT NULL');
        $this->addColumn('{{user}}', 'phone', 'varchar(255) NOT NULL');
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
        return true;
    }
}
