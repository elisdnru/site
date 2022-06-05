<?php

declare(strict_types=1);

return [
    'first-root' => [
        'id' => 1,
        'sort' => 1,
        'parent_id' => null,
        'slug' => 'first-root',
        'title' => 'First Root',
    ],
    'first-root-first-middle' => [
        'id' => 11,
        'sort' => 1,
        'parent_id' => 1,
        'slug' => 'first-root-first-middle',
        'title' => 'First Root First Middle',
    ],
    'first-middle-child' => [
        'id' => 111,
        'sort' => 1,
        'parent_id' => 11,
        'slug' => 'first-middle-child',
        'title' => 'First Root First Middle Child',
    ],
    'first-root-second-middle' => [
        'id' => 12,
        'sort' => 2,
        'parent_id' => 1,
        'slug' => 'first-root-second-middle',
        'title' => 'First Root Second Middle',
    ],
    'second-root' => [
        'id' => 2,
        'sort' => 2,
        'parent_id' => null,
        'slug' => 'second-root',
        'title' => 'Second Root',
    ],
    'third-root' => [
        'id' => 3,
        'sort' => 3,
        'parent_id' => null,
        'slug' => 'third-root',
        'title' => 'Third Root',
    ],
];
