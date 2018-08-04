<?php

class m130826_093826_rename_module extends EDbMigration
{
	public function safeUp()
	{
		$this->renameTable('{{gallery}}', '{{new_gallery}}');
		$this->execute('UPDATE {{module}} SET module = "newgallery" WHERE module = "gallery"');
	}

	public function safeDown()
	{
		$this->renameTable('{{new_gallery}}', '{{gallery}}');
		$this->execute('UPDATE {{module}} SET module = "gallery" WHERE module = "newgallery"');
	}
}