<?php

use yii\db\Migration;

class m180806_105834_remove_language_tables extends Migration
{
    public function safeUp(): bool
    {
        /**
         * TODO: Remove after getTableSchema fixes
         * @psalm-suppress DocblockTypeContradiction
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        if ($this->getDb()->getTableSchema('{{comment}}')?->getColumn('lang_id')) {
            $this->dropColumn('{{comment}}', 'lang_id');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105834_remove_language_tables does not support migration down.\n";
        return false;
    }
}
