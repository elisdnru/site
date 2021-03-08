<?php

use yii\db\Migration;

class m210125_100812_rename_meta extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('blog_categories', 'pagetitle', 'meta_title');
        $this->renameColumn('blog_categories', 'description', 'meta_description');
        $this->renameColumn('blog_posts', 'pagetitle', 'meta_title');
        $this->renameColumn('blog_posts', 'description', 'meta_description');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('blog_categories', 'meta_title', 'pagetitle');
        $this->renameColumn('blog_categories', 'meta_description', 'description');
        $this->renameColumn('blog_posts', 'meta_title', 'pagetitle');
        $this->renameColumn('blog_posts', 'meta_description', 'description');
        return true;
    }
}
