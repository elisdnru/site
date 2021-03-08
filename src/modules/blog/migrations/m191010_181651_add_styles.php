<?php

use yii\db\Migration;

class m191010_181651_add_styles extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('blog_posts', 'styles', 'TEXT DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropColumn('blog_posts', 'styles');
        return true;
    }
}
