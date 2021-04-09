<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

class M191007111239InlinePageLayout extends Migration
{
    public function safeUp(): bool
    {
        $this->addColumn('{{page}}', 'layout', 'varchar(255) DEFAULT NULL');
        $this->addColumn('{{page}}', 'subpages_layout', 'varchar(255) DEFAULT NULL');

        $this->execute(
            'UPDATE {{page}} AS p SET layout = (SELECT l.alias FROM {{page_layout}} AS l WHERE l.id = p.layout_id)'
        );
        $this->execute(
            'UPDATE {{page}} AS p SET ' .
            'subpages_layout = (SELECT l.alias FROM {{page_layout_subpages}} AS l WHERE l.id = p.layout_subpages_id)'
        );

        $this->alterColumn('{{page}}', 'layout', 'varchar(255) NOT NULL');
        $this->alterColumn('{{page}}', 'subpages_layout', 'varchar(255) NOT NULL');

        $this->dropColumn('{{page}}', 'layout_id');
        $this->dropColumn('{{page}}', 'layout_subpages_id');

        $this->dropTable('{{page_layout}}');
        $this->dropTable('{{page_layout_subpages}}');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m191007_111239_inline_page_layout does not support migration down.\n";
        return false;
    }
}
