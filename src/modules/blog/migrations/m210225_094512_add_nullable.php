<?php

use yii\db\Migration;

class m210225_094512_add_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) NOT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) NOT NULL');
        return true;
    }
}
