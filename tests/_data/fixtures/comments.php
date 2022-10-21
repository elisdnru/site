<?php

declare(strict_types=1);

return [
    [
        'id' => 1,
        'type' => 'app\\modules\\blog\\models\\Post',
        'material_id' => 6,
        'user_id' => 2,
        'name' => 'User',
        'email' => 'user@app.test',
        'site' => '',
        'text' => 'Public Comment',
        'date' => '2019-10-24 09:53:19',
        'parent_id' => null,
        'public' => 1,
        'moder' => 0,
        'likes' => 2,
    ],
    [
        'id' => 2,
        'type' => 'app\\modules\\blog\\models\\Post',
        'material_id' => 6,
        'user_id' => 1,
        'name' => 'User',
        'email' => 'user@app.test',
        'site' => '',
        'text' => 'Draft Comment',
        'date' => '2019-10-24 09:53:19',
        'parent_id' => null,
        'public' => 0,
        'moder' => 0,
        'likes' => 0,
    ],
    [
        'id' => 3,
        'type' => 'app\\modules\\blog\\models\\Post',
        'material_id' => 6,
        'user_id' => 1,
        'name' => 'Admin',
        'email' => 'admin@app.test',
        'site' => '',
        'text' => 'Admin Comment',
        'date' => '2019-10-24 09:53:19',
        'parent_id' => null,
        'public' => 1,
        'moder' => 0,
        'likes' => 0,
    ],
    [
        'id' => 4,
        'type' => 'app\\modules\\blog\\models\\Post',
        'material_id' => 6,
        'user_id' => 2,
        'name' => 'User',
        'email' => 'author@app.test',
        'site' => '',
        'text' => 'User Comment',
        'date' => '2019-10-24 09:53:19',
        'parent_id' => null,
        'public' => 1,
        'moder' => 0,
        'likes' => 0,
    ],
    [
        'id' => 5,
        'type' => 'app\\modules\\blog\\models\\Post',
        'material_id' => 6,
        'user_id' => 2,
        'name' => 'User',
        'email' => 'author@app.test',
        'site' => '',
        'text' => <<<'END'
            Lorem ipsum dolor sit amet.

            <p onclick="script()">XSS</p>

            <pre>
            <p>Code</p>
            <script>alert('XSS');</script>
            </pre>

            <script>alert('XSS');</script>
            END,
        'date' => '2019-10-24 09:53:19',
        'parent_id' => null,
        'public' => 1,
        'moder' => 0,
        'likes' => 0,
    ],
];
