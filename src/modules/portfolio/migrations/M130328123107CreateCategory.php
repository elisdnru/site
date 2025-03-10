<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328123107CreateCategory extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('{{portfolio_category}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('parent_id', '{{portfolio_category}}', 'parent_id');

        $this->createIndex('sort', '{{portfolio_category}}', 'sort');
        $this->createIndex('alias', '{{portfolio_category}}', 'alias');

        $this->createTable('{{portfolio_category_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{portfolio_category_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{portfolio_category_lang}}', 'owner_id');

        $this->addForeignKey(
            'portfolio_category_lang_owner',
            '{{portfolio_category_lang}}',
            'owner_id',
            '{{portfolio_category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropForeignKey('portfolio_category_lang_owner', '{{portfolio_category_lang}}');

        $this->dropTable('{{portfolio_category_lang}}');
        $this->dropTable('{{portfolio_category}}');
        return true;
    }
}
