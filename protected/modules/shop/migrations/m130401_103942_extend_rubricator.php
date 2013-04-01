<?php

class m130401_103942_extend_rubricator extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_rubric}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'rubric_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_product_rubric}}', 'product_id');
        $this->createIndex('rubric_id', '{{shop_product_rubric}}', 'rubric_id');

        $products = $this->getDbConnection()->createCommand('SELECT id, rubric_id FROM {{shop_product}}')->queryAll();
        foreach ($products as $item)
        {
            $this->insert('{{shop_product_rubric}}', array(
                'product_id' => $item['id'],
                'rubric_id' => $item['rubric_id'],
            ));
        }

        $this->dropColumn('{{shop_product}}', 'rubric_id');
    }

    public function safeDown()
    {
        $this->addColumn('{{shop_product}}', 'rubric_id', 'int(11) NOT NULL');
        $this->createIndex('rubric_id', '{{shop_product}}', 'rubric_id');

        $relations = $this->getDbConnection()->createCommand('SELECT product_id, rubric_id FROM {{shop_product_rubric}} GROUP BY product_id')->queryAll();
        foreach ($relations as $item)
        {
            $this->getDbConnection()->createCommand('UPDATE {{shop_product}} SET rubric_id = :rubric_id WHERE id = :id')->execute(array(
                'rubric_id' => $item['rubric_id'],
                'id' => $item['product_id'],
            ));
        }

        $this->dropTable('{{shop_product_rubric}}');
    }
}