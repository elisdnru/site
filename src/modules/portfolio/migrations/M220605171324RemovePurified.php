<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220605171324RemovePurified extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->dropColumn('portfolio_works', 'short_purified');
        $this->dropColumn('portfolio_works', 'text_purified');

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->addColumn('portfolio_works', 'short_purified', 'text NOT NULL');
        $this->addColumn('portfolio_works', 'text_purified', 'mediumtext NOT NULL');

        return true;
    }
}
