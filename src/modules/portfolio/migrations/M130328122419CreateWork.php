<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use Override;
use yii\db\Migration;

/**
 * @psalm-api
 */
final class M130328122419CreateWork extends Migration
{
    #[Override]
    public function safeUp(): bool
    {
        $this->createTable('{{portfolio_work}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'date' => 'datetime NOT NULL',
            'category_id' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'image_show' => 'tinyint(1) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('category_id', '{{portfolio_work}}', 'category_id');

        $this->createIndex('sort', '{{portfolio_work}}', 'sort');
        $this->createIndex('date', '{{portfolio_work}}', 'date');
        $this->createIndex('alias', '{{portfolio_work}}', 'alias');
        $this->createIndex('public', '{{portfolio_work}}', 'public');

        $this->createTable('{{portfolio_work_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_short' => 'text NOT NULL',
            'l_short_purified' => 'text NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_text_purified' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{portfolio_work_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{portfolio_work_lang}}', 'owner_id');

        $this->addForeignKey(
            'portfolio_work_lang_owner',
            '{{portfolio_work_lang}}',
            'owner_id',
            '{{portfolio_work}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        return true;
    }

    #[Override]
    public function safeDown(): bool
    {
        $this->dropForeignKey('portfolio_work_lang_owner', '{{portfolio_work_lang}}');

        $this->dropTable('{{portfolio_work_lang}}');
        $this->dropTable('{{portfolio_work}}');
        return true;
    }
}
