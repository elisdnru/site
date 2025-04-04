<?php

declare(strict_types=1);

namespace app\modules\comment\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191025193912AddNullable extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->alterColumn('comments', 'parent_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('comments', 'user_id', 'int(11) DEFAULT NULL');

        $this->update('comments', ['parent_id' => null], 'parent_id = 0');
        $this->update('comments', ['user_id' => null], 'user_id = 0');

        $this->execute(
            'DELETE FROM comments WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT u.id FROM users AS u)'
        );

        $this->addForeignKey('comments_user', 'comments', 'user_id', 'users', 'id');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        return false;
    }
}
