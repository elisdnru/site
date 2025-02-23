<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605154016RenameAlias extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropIndex('alias', 'portfolio_categories');
        $this->renameColumn('portfolio_categories', 'alias', 'slug');
        $this->createIndex('slug', 'portfolio_categories', 'slug', true);

        $this->dropIndex('alias', 'portfolio_works');
        $this->renameColumn('portfolio_works', 'alias', 'slug');
        $this->createIndex('slug', 'portfolio_works', 'slug', true);

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'portfolio_categories');
        $this->renameColumn('portfolio_categories', 'slug', 'alias');
        $this->createIndex('alias', 'portfolio_categories', 'alias', true);

        $this->dropIndex('slug', 'portfolio_works');
        $this->renameColumn('portfolio_works', 'slug', 'alias');
        $this->createIndex('alias', 'portfolio_works', 'alias', true);

        return true;
    }
}
