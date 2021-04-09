<?php

use yii\db\Migration;

class m191007_115557_rename_tables extends Migration
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
