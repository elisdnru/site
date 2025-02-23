<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M191007115557RenameTables extends Migration
{
    private const array TABLES = [
        'portfolio_category' => 'portfolio_categories',
        'portfolio_work' => 'portfolio_works',
    ];

    #[Override]
    public function safeUp(): bool
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable('{{' . $old . '}}', $new);
        }
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable($new, '{{' . $old . '}}');
        }
        return true;
    }
}
