<?php

use yii\db\Migration;

class m190806_190154_remove_gallery extends Migration
{
    public function safeUp(): bool
    {
        /**
         * @psalm-suppress DocblockTypeContradiction
         * @psalm-suppress RedundantConditionGivenDocblockType
         */
        if ($this->getDb()->getTableSchema('{{blog_post}}')?->getColumn('gallery_id')) {
            $this->dropColumn('{{blog_post}}', 'gallery_id');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m190806_190154_remove_gallery does not support migration down.\n";
        return false;
    }
}
