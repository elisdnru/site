<?php

use yii\db\Migration;

class m191020_153212_remove_keywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('blog_posts', 'keywords');
        $this->dropColumn('blog_categories', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('blog_posts', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('blog_categories', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
