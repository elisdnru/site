<?php

class m180806_112238_remove_unused_configs extends EDbMigration
{
	public function safeUp()
	{
        if (!$this->getDbConnection()->getSchema()->getTable('{{config}}')) {
            return;
        }

	    $this->delete('{{config}}', ['in', 'param', [
            'CALLME.SEND_ADMIN_EMAILS',
            'INTEREST.ALL_LINK',
            'PERSONNEL.ITEMS_PER_PAGE',
            'RUBRICATOR.ITEMS_PER_PAGE',
            'SHOP.PRODUCTS_PER_PAGE',
            'SHOP.ORDER_AGREEMENT',
            'SHOP.GROUP_BY_TITLE',
            'SHOP.SEND_ADMIN_EMAILS',
            'USERPHOTO.ITEMS_PER_PAGE',
            'USERPHOTO.MAX_COUNT',
        ]]);
	}

	public function safeDown()
	{
        echo "m180806_112238_remove_unused_configs does not support migration down.\n";
        return false;
	}
}