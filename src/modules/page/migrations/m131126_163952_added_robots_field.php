<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m131126_163952_added_robots_field extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{page}}', 'robots', 'varchar(64) NOT NULL');
        $this->createIndex('robots', '{{page}}', 'robots');
        $this->execute('UPDATE {{page}} SET robots = \'index, follow\'');
    }

    public function safeDown()
    {
        $this->dropIndex('robots', '{{page}}');
        $this->dropColumn('{{page}}', 'robots');
    }
}
