<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use yii\db\Migration;

final class M191007115557RenameTables extends Migration
{
    private const TABLES = [
        'portfolio_category' => 'portfolio_categories',
        'portfolio_work' => 'portfolio_works',
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
