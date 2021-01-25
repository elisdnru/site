<?php

use yii\db\Migration;

class m210125_100813_rename_meta extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('pages', 'pagetitle', 'meta_title');
        $this->renameColumn('pages', 'description', 'meta_description');
    }

    public function safeDown()
    {
        $this->renameColumn('pages', 'meta_title', 'pagetitle');
        $this->renameColumn('pages', 'meta_description', 'description');
    }
}
