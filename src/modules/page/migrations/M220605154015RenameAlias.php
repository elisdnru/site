<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605154015RenameAlias extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropIndex('alias', 'pages');
        $this->renameColumn('pages', 'alias', 'slug');
        $this->createIndex('slug', 'pages', 'slug', true);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'pages');
        $this->renameColumn('pages', 'slug', 'alias');
        $this->createIndex('alias', 'pages', 'alias', true);
        return true;
    }
}
