<?php

use app\extensions\migrate\EDbMigration;

class m191007_135558_rehash_passwords extends EDbMigration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'password', 'varchar(255) DEFAULT NULL');

        $rows = $this->dbConnection->createCommand()
            ->select('id, password')
            ->from('users')
            ->andWhere('LENGTH(password) = 32')
            ->queryAll();

        foreach ($rows as $row) {
            echo 'Rehash ' . $row['id'] . PHP_EOL;
            $this->update('users',
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
