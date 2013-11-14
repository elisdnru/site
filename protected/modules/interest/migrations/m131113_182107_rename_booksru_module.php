<?php

class m131113_182107_rename_booksru_module extends EDbMigration
{
	public function safeUp()
	{
		$partner = (int)Yii::app()->config->get('BOOKSRU.PARTNER_ID');

		$this->renameTable('{{booksru_book}}', '{{interest_item}}');

		$this->addColumn('{{interest_item}}', 'link', 'varchar(255) NOT NULL');

		$this->execute("UPDATE {{interest_item}} SET link = CONCAT('http://www.books.ru/books/', alias, '/?show=1&partner=" . $partner . "')");

		$this->dropColumn('{{interest_item}}', 'code');
		$this->dropColumn('{{interest_item}}', 'alias');
		$this->dropColumn('{{interest_item}}', 'free');
	}

	public function safeDown()
	{
		$this->renameTable('{{interest_item}}', '{{booksru_book}}');

		$this->addColumn('{{booksru_book}}', 'code', 'varchar(255) NOT NULL');
		$this->addColumn('{{booksru_book}}', 'alias', 'varchar(255) NOT NULL');
		$this->addColumn('{{booksru_book}}', 'free', 'tinyint(1) NOT NULL');

		$this->update('{{booksru_book}}', array('free'=>1));

		$rows = $this->getDbConnection()->createCommand('SELECT id, link FROM {{booksru_book}}')->queryAll();

		foreach ($rows as $row) {
			if (preg_match('#^http://www.books.ru/books/(?P<alias>.+)-(?P<code>\d+)/\?show=1#is', $row['link'], $matches)) {
				$this->update('{{booksru_book}}', array(
					'code'=>$matches['code'],
					'alias'=>$matches['alias'],
				), 'id=:id', array('id'=>$row['id']));
			}
		}

		$this->dropColumn('{{booksru_book}}', 'link');
	}
}