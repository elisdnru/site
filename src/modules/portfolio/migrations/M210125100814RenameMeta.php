<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M210125100814RenameMeta extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameColumn('portfolio_categories', 'pagetitle', 'meta_title');
        $this->renameColumn('portfolio_categories', 'description', 'meta_description');
        $this->renameColumn('portfolio_works', 'pagetitle', 'meta_title');
        $this->renameColumn('portfolio_works', 'description', 'meta_description');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameColumn('portfolio_categories', 'meta_title', 'pagetitle');
        $this->renameColumn('portfolio_categories', 'meta_description', 'description');
        $this->renameColumn('portfolio_works', 'meta_title', 'pagetitle');
        $this->renameColumn('portfolio_works', 'meta_description', 'description');
        return true;
    }
}
