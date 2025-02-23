<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M210125100813RenameMeta extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->renameColumn('pages', 'pagetitle', 'meta_title');
        $this->renameColumn('pages', 'description', 'meta_description');
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->renameColumn('pages', 'meta_title', 'pagetitle');
        $this->renameColumn('pages', 'meta_description', 'description');
        return true;
    }
}
