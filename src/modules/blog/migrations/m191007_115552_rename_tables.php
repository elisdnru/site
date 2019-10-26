<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115552_rename_tables extends EDbMigration
{
    private const TABLES = [
        'blog_category' => 'blog_categories',
        'blog_post' => 'blog_posts',
        'blog_post_group' => 'blog_post_groups',
        'blog_post_tag' => 'blog_post_tags',
        'blog_tag' => 'blog_tags',
    ];

    public function safeUp()
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable('{{' . $old . '}}', $new);
        }
    }

    public function safeDown()
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable($new, '{{' . $old . '}}');
        }
    }
}
