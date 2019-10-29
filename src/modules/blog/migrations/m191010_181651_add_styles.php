<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191010_181651_add_styles extends Migration
{
    public function safeUp()
    {
        $this->addColumn('blog_posts', 'styles', 'TEXT DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('blog_posts', 'styles');
    }
}
