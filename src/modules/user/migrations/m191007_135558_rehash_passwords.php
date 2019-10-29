<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;
use yii\db\Query;

class m191007_135558_rehash_passwords extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'password', 'varchar(255) DEFAULT NULL');

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
    }

    public function safeDown()
    {
        echo "m191007_135558_rehash_passwords does not support migration down.\n";
        return false;
    }
}
