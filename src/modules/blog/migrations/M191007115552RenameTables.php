<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use yii\db\Migration;

final class M191007115552RenameTables extends Migration
{
    private const TABLES = [
        'blog_category' => 'blog_categories',
        'blog_post' => 'blog_posts',
        'blog_post_group' => 'blog_post_groups',
        'blog_post_tag' => 'blog_post_tags',
        'blog_tag' => 'blog_tags',
    ];

    public function safeUp(): bool
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable('{{' . $old . '}}', $new);
        }
        return true;
    }

    public function safeDown(): bool
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable($new, '{{' . $old . '}}');
        }
        return true;
    }
}
