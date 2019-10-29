<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191025_175116_remove_image extends Migration
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
