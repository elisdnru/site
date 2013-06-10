<?php

class m130610_115704_product_title_index extends EDbMigration
{
	public function safeUp()
	{
		$this->createIndex('title', '{{shop_product}}', 'title');
	}

	public function safeDown()
	{
		$this->dropIndex('title', '{{shop_product}}');
	}
}