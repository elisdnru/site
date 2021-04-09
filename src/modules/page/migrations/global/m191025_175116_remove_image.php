<?php

use yii\db\Migration;

class m191025_175116_remove_image extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'image');
        $this->dropColumn('pages', 'image_width');
        $this->dropColumn('pages', 'image_height');
        $this->dropColumn('pages', 'image_alt');
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
