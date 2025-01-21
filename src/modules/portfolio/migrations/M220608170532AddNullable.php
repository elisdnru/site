<?php

declare(strict_types=1);

namespace app\modules\portfolio\migrations;

use yii\db\Migration;

/**
 * @psalm-api
 */
final class M220608170532AddNullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('portfolio_works', 'image', 'varchar(255) DEFAULT NULL');
        $this->update('portfolio_works', ['image' => null], ['image' => '']);

        return true;
    }

    public function safeDown(): bool
    {
        $this->update('portfolio_works', ['image' => ''], ['image' => null]);
        $this->alterColumn('portfolio_works', 'image', 'varchar(255) NOT NULL');

        return true;
    }
}
