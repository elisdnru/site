<?php

use app\extensions\migrate\EDbMigration;

class m191023_111425_remove_comments_count extends EDbMigration
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
