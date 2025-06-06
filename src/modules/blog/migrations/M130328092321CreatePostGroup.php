<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328092321CreatePostGroup extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('{{blog_post_group}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropTable('{{blog_post_group}}');
        return true;
    }
}
