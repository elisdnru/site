<?php

declare(strict_types=1);

namespace app\modules\blog\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605154013RenameAlias extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropIndex('alias', 'blog_posts');
        $this->renameColumn('blog_posts', 'alias', 'slug');
        $this->createIndex('slug', 'blog_posts', 'slug', true);

        $this->dropIndex('alias', 'blog_categories');
        $this->renameColumn('blog_categories', 'alias', 'slug');
        $this->createIndex('slug', 'blog_categories', 'slug', true);

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'blog_posts');
        $this->renameColumn('blog_posts', 'slug', 'alias');
        $this->createIndex('alias', 'blog_posts', 'alias', true);

        $this->dropIndex('slug', 'blog_categories');
        $this->renameColumn('blog_categories', 'slug', 'alias');
        $this->createIndex('alias', 'blog_categories', 'alias', true);

        return true;
    }
}
