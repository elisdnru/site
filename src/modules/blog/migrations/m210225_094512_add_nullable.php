<?php

use yii\db\Migration;

class m210225_094512_add_nullable extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) DEFAULT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('blog_posts', 'image_width', 'int(11) NOT NULL');
        $this->alterColumn('blog_posts', 'image_height', 'int(11) NOT NULL');
    }
}
