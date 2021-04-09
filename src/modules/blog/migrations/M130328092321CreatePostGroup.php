<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

class M130328092321CreatePostGroup extends Migration
{
    public function safeUp(): bool
    {
        $this->createTable('{{blog_post_group}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTable('{{blog_post_group}}');
        return true;
    }
}
