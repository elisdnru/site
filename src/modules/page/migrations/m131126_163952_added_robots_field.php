<?php

class m131126_163952_added_robots_field extends EDbMigration
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