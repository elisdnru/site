<?php

use app\extensions\migrate\EDbMigration;

class m191010_181651_add_styles extends EDbMigration
{
    public function safeUp()
    {
        $this->addColumn('blog_posts', 'styles', 'TEXT DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('blog_posts', 'styles');
    }
}
