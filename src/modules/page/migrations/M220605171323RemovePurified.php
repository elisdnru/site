<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605171323RemovePurified extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('pages', 'text_purified');

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('pages', 'text_purified', 'mediumtext NOT NULL');

        return true;
    }
}
