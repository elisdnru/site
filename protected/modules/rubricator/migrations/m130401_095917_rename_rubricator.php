<?php

class m130401_095917_rename_rubricator extends EDbMigration
{
    public function safeUp()
    {
        $this->dropForeignKey('rubrikator_category_lang_owner', '{{rubrikator_category_lang}}');

        $this->renameTable('{{rubrikator_category}}', '{{rubricator_category}}');
        $this->renameTable('{{rubrikator_category_lang}}', '{{rubricator_category_lang}}');

        $this->addForeignKey('rubricator_category_lang_owner', '{{rubricator_category_lang}}', 'owner_id', '{{rubricator_category}}', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('rubrikator_article_lang_owner', '{{rubrikator_article_lang}}');

        $this->renameTable('{{rubrikator_article}}', '{{rubricator_article}}');
        $this->renameTable('{{rubrikator_article_lang}}', '{{rubricator_article_lang}}');

        $this->addForeignKey('rubricator_article_lang_owner', '{{rubricator_article_lang}}', 'owner_id', '{{rubricator_article}}', 'id', 'CASCADE', 'CASCADE');

        $this->getDbConnection()->createCommand('UPDATE {{config}} SET param = "RUBRICATOR.ITEMS_PER_PAGE" WHERE param = "RUBRIKATOR.ITEMS_PER_PAGE"')->execute();
    }

    public function safeDown()
    {

        $this->dropForeignKey('rubricator_category_lang_owner', '{{rubricator_category_lang}}');

        $this->renameTable('{{rubricator_category}}', '{{rubrikator_category}}');
        $this->renameTable('{{rubricator_category_lang}}', '{{rubrikator_category_lang}}');

        $this->addForeignKey('rubrikator_category_lang_owner', '{{rubrikator_category_lang}}', 'owner_id', '{{rubrikator_category}}', 'id', 'CASCADE', 'CASCADE');

        $this->dropForeignKey('rubricator_article_lang_owner', '{{rubricator_article_lang}}');

        $this->renameTable('{{rubricator_article}}', '{{rubrikator_article}}');
        $this->renameTable('{{rubricator_article_lang}}', '{{rubrikator_article_lang}}');

        $this->addForeignKey('rubrikator_article_lang_owner', '{{rubrikator_article_lang}}', 'owner_id', '{{rubrikator_article}}', 'id', 'CASCADE', 'CASCADE');

        $this->getDbConnection()->createCommand('UPDATE {{config}} SET param = "RUBRIKATOR.ITEMS_PER_PAGE" WHERE param = "RUBRICATOR.ITEMS_PER_PAGE"')->execute();
    }
}