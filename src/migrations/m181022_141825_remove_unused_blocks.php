<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m181022_141825_remove_unused_blocks extends Migration
{
    public function safeUp()
    {
        $this->delete('{{block}}', ['in', 'alias', [
            'header',
            'footer',
            'copyright',
        ]]);
    }

    public function safeDown()
    {
        echo "m180806_112238_remove_unused_configs does not support migration down.\n";
        return false;
    }
}
