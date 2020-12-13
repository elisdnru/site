<?php

use yii\db\Migration;

class m201213_171234_add_nullable extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('blog_categories', 'parent_id', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'group_id', 'int(11) DEFAULT NULL');

        $this->update('blog_categories', ['parent_id' => null], ['parent_id' => 0]);
        $this->update('blog_posts', ['group_id' => null], ['group_id' => 0]);
    }

    public function safeDown(): bool
    {
        return false;
    }
}
