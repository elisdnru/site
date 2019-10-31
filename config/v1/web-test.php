<?php

return array_replace_recursive(
    require(__DIR__ . '/web.php'),
    [
        'components' => [
            'db' => [
                'connectionString' => 'mysql:host=mysql-test;dbname=test',
                'username' => 'test',
                'password' => 'secret',
            ],
        ],
    ]
);
