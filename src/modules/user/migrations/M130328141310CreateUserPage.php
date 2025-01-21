<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328141310CreateUserPage extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{user_page}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'page_id' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('user_id', '{{user_page}}', 'user_id');
        $this->createIndex('page_id', '{{user_page}}', 'page_id');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('{{user_page}}');
        return true;
    }
}
