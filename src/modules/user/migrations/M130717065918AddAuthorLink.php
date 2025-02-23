<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130717065918AddAuthorLink extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropColumn('{{user}}', 'googleplus');
        return true;
    }
}
