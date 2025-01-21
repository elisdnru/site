<?php

declare(strict_types=1);

namespace app\modules\page\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220607183717RemoveUnique extends Migration
{
    public function safeUp(): bool
    {
        $this->dropIndex('slug', 'pages');
        $this->createIndex('slug', 'pages', 'slug');
        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex('slug', 'pages');
        $this->createIndex('slug', 'pages', 'slug', true);
        return true;
    }
}
