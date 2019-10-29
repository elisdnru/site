<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191023_111425_remove_comments_count extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('blog_posts', 'comments_count');
        $this->dropColumn('blog_posts', 'comments_new_count');
    }

    public function safeDown(): bool
    {
        return false;
    }
}
