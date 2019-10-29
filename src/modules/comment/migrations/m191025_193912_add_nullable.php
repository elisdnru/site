<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191025_193912_add_nullable extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('comments', 'parent_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('comments', 'user_id', 'int(11) DEFAULT NULL');

        $this->update('comments', ['parent_id' => null], 'parent_id = 0');
        $this->update('comments', ['user_id' => null], 'user_id = 0');

        $this->execute('DELETE FROM comments WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT u.id FROM users AS u)');

        $this->addForeignKey('comments_user', 'comments', 'user_id', 'users', 'id');
    }

    public function safeDown(): bool
    {
        return false;
    }
}
