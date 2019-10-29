<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m181022_112914_remove_modules_table extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('{{module}}')) {
            $this->dropTable('{{module}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
