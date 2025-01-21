<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191020153214RemoveKeywords extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('portfolio_works', 'keywords');
        $this->dropColumn('portfolio_categories', 'keywords');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('portfolio_works', 'keywords', 'varchar(255) DEFAULT NULL');
        $this->addColumn('portfolio_categories', 'keywords', 'varchar(255) DEFAULT NULL');
        return true;
    }
}
