<?php

class m130331_131735_add_text_field extends EDbMigration
{
	public function safeUp()
	{
        $this->addColumn('{{user_photo}}', 'text', 'text NOT NULL AFTER title');
        $this->addColumn('{{user_photo}}', 'text_purified', 'text NOT NULL AFTER text');
	}

	public function safeDown()
	{
        $this->dropColumn('{{user_photo}}', 'text');
        $this->dropColumn('{{user_photo}}', 'text_purified');
	}
}