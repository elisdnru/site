<?php

use yii\db\Migration;

class m210125_100814_rename_meta extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('portfolio_categories', 'pagetitle', 'meta_title');
        $this->renameColumn('portfolio_categories', 'description', 'meta_description');
        $this->renameColumn('portfolio_works', 'pagetitle', 'meta_title');
        $this->renameColumn('portfolio_works', 'description', 'meta_description');
    }

    public function safeDown()
    {
        $this->renameColumn('portfolio_categories', 'meta_title', 'pagetitle');
        $this->renameColumn('portfolio_categories', 'meta_description', 'description');
        $this->renameColumn('portfolio_works', 'meta_title', 'pagetitle');
        $this->renameColumn('portfolio_works', 'meta_description', 'description');
    }
}
