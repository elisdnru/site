<?php

declare(strict_types=1);

namespace app\modules\user\migrations;

use yii\db\Migration;
use yii\db\Query;

class M191007135558RehashPasswords extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('users', 'password', 'varchar(255) DEFAULT NULL');

        /**
         * @psalm-var array<array-key, array{id: int, password: string}> $rows
         */
        $rows = (new Query())
            ->select('id, password')
            ->from('users')
            ->andWhere('LENGTH(password) = 32')
            ->all($this->getDb());

        foreach ($rows as $row) {
            echo 'Rehash ' . $row['id'] . PHP_EOL;
            $this->update(
                'users',
                ['password' => password_hash($row['password'], PASSWORD_DEFAULT)],
                'id = :current_id AND LENGTH(password) = 32',
                [':current_id' => $row['id']]
            );
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m191007_135558_rehash_passwords does not support migration down.\n";
        return false;
    }
}
