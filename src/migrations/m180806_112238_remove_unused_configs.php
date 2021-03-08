<?php

use yii\db\Migration;

class m180806_112238_remove_unused_configs extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{config}}')) {
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
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_112238_remove_unused_configs does not support migration down.\n";
        return false;
    }
}
