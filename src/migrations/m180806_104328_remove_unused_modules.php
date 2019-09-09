<?php

class m180806_104328_remove_unused_modules extends EDbMigration
{
    public function safeUp()
    {
        if (!$this->getDbConnection()->getSchema()->getTable('{{callme}}')) {
            return;
        }

        $this->dropTable('{{callme}}');
        $this->dropTable('{{graduate_graduate}}');
        $this->dropTable('{{graduate_grade}}');

        $this->dropTable('{{interest_item}}');

        $this->dropTable('{{personnel_employee_lang}}');
        $this->dropTable('{{personnel_employee}}');
        $this->dropTable('{{personnel_category_lang}}');
        $this->dropTable('{{personnel_category}}');

        $this->dropTable('{{recipe_lang}}');
        $this->dropTable('{{recipe}}');

        $this->dropTable('{{review}}');

        $this->dropTable('{{shop_order_product}}');
        $this->dropTable('{{shop_order}}');
        $this->dropTable('{{shop_product_rubric}}');
        $this->dropTable('{{shop_product_color}}');
        $this->dropTable('{{shop_type}}');
        $this->dropTable('{{shop_product_size}}');
        $this->dropTable('{{shop_size}}');
        $this->dropTable('{{shop_product_othercategory}}');
        $this->dropTable('{{shop_product}}');
        $this->dropTable('{{shop_post_type}}');
        $this->dropTable('{{shop_model}}');
        $this->dropTable('{{shop_image}}');
        $this->dropTable('{{shop_color}}');
        $this->dropTable('{{shop_brand_category}}');
        $this->dropTable('{{shop_category}}');
        $this->dropTable('{{shop_brand}}');
        $this->dropTable('{{shop_attribute_value}}');
        $this->dropTable('{{shop_attribute}}');

        $this->dropTable('{{rubricator_category_lang}}');
        $this->dropTable('{{rubricator_category}}');
        $this->dropTable('{{rubricator_article_lang}}');
        $this->dropTable('{{rubricator_article}}');

        $this->dropTable('{{slideshow}}');

        $this->dropTable('{{user_photo}}');
    }

    public function safeDown()
    {
        echo "m180806_104328_remove_unused_modules does not support migration down.\n";
        return false;
    }
}
