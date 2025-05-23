<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328122139CreatePageLayout extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('{{page_layout}}', [
            'id' => 'int(11) NOT NULL PRIMARY KEY',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('alias', '{{page_layout}}', 'alias');

        $this->insert('{{page_layout}}', [
            'id' => 0,
            'alias' => 'default',
            'title' => 'По умолчанию',
        ]);

        $this->insert('{{page_layout}}', [
            'id' => 1,
            'alias' => 'fullscreen',
            'title' => 'Во всю ширину',
        ]);

        $this->insert('{{page_layout}}', [
            'id' => 2,
            'alias' => 'leftcolumn',
            'title' => 'Колонка с левым сайдбаром',
        ]);

        $this->insert('{{page_layout}}', [
            'id' => 3,
            'alias' => 'rightcolumn',
            'title' => 'Колонка с правым сайдбаром',
        ]);

        $this->insert('{{page_layout}}', [
            'id' => 4,
            'alias' => 'blank',
            'title' => 'Полноэкранный без контейнера',
        ]);

        $this->createTable('{{page_layout_subpages}}', [
            'id' => 'int(11) NOT NULL PRIMARY KEY',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('alias', '{{page_layout_subpages}}', 'alias');

        $this->insert('{{page_layout_subpages}}', [
            'id' => 0,
            'alias' => 'default',
            'title' => 'Не отображать (по умолчанию)',
        ]);

        $this->insert('{{page_layout_subpages}}', [
            'id' => 1,
            'alias' => 'tabs',
            'title' => 'Взаимные вкладки',
        ]);

        $this->insert('{{page_layout_subpages}}', [
            'id' => 2,
            'alias' => 'tabschild',
            'title' => 'Дочерние вкладки',
        ]);
        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropTable('{{page_layout}}');
        $this->dropTable('{{page_layout_subpages}}');
        return true;
    }
}
