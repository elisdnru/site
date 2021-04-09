<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

class M131126163952AddedRobotsField extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('{{page}}', 'robots', 'varchar(64) NOT NULL');
        $this->createIndex('robots', '{{page}}', 'robots');
        $this->execute('UPDATE {{page}} SET robots = \'index, follow\'');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('robots', '{{page}}');
        $this->dropColumn('{{page}}', 'robots');
        return true;
    }
}
