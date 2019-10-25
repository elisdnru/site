<?php

use app\extensions\migrate\EDbMigration;

class m191025_175116_remove_image extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('pages', 'image');
        $this->dropColumn('pages', 'image_width');
        $this->dropColumn('pages', 'image_height');
        $this->dropColumn('pages', 'image_alt');
    }

    public function safeDown(): bool
    {
        return false;
    }
}
