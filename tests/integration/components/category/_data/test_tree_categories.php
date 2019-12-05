<?php

return [
    'first-root' => [
        'id' => 1,
        'sort' => 1,
        'parent_id' => 0,
        'alias' => 'first-root',
        'title' => 'First Root',
    ],
    'first-root-first-middle' => [
        'id' => 11,
        'sort' => 1,
        'parent_id' => 1,
        'alias' => 'first-root-first-middle',
        'title' => 'First Root First Middle',
    ],
    'first-middle-child' => [
        'id' => 111,
        'sort' => 1,
        'parent_id' => 11,
        'alias' => 'first-middle-child',
        'title' => 'First Root First Middle Child',
    ],
    'first-root-second-middle' => [
        'id' => 12,
        'sort' => 2,
        'parent_id' => 1,
        'alias' => 'first-root-second-middle',
        'title' => 'First Root Second Middle',
    ],
    'second-root' => [
        'id' => 2,
        'sort' => 2,
        'parent_id' => null,
        'alias' => 'second-root',
        'title' => 'Second Root',
    ],
    'third-root' => [
        'id' => 3,
        'sort' => 3,
        'parent_id' => null,
        'alias' => 'third-root',
        'title' => 'Third Root',
    ],
];
