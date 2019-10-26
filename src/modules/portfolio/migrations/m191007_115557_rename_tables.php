<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115557_rename_tables extends EDbMigration
{
    private const TABLES = [
        'portfolio_category' => 'portfolio_categories',
        'portfolio_work' => 'portfolio_works',
    ];

    public function safeUp()
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable('{{' . $old . '}}', $new);
        }
    }

    public function safeDown()
    {
        foreach (self::TABLES as $old => $new) {
            $this->renameTable($new, '{{' . $old . '}}');
        }
    }
}
