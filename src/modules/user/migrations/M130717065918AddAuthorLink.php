<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

final class M130717065918AddAuthorLink extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('{{user}}', 'googleplus');
        return true;
    }
}
