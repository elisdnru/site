<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m180806_105831_remove_language_tables extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{block_lang}}')) {
            $this->dropTable('{{block_lang}}');
        }

        $this->dropTable('{{blog_post_lang}}');
        $this->dropTable('{{blog_category_lang}}');
        $this->dropTable('{{menu_lang}}');

        if ($this->getDbConnection()->getSchema()->getTable('{{new_lang}}')) {
            $this->dropTable('{{new_lang}}');
        }

        $this->dropTable('{{page_lang}}');
        $this->dropTable('{{portfolio_work_lang}}');
        $this->dropTable('{{portfolio_category_lang}}');

        $this->dropColumn('{{comment}}', 'lang_id');
    }

    public function safeDown()
    {
        echo "m180806_105831_remove_language_tables does not support migration down.\n";
        return false;
    }
}
