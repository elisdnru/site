<?php

use yii\db\Migration;

class m191007_115556_rename_tables extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{page}}', 'pages');
    }

    public function safeDown()
    {
        $this->renameTable('pages', '{{page}}');
    }
}
