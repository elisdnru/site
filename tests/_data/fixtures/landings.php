<?php

declare(strict_types=1);

return [
    'child' => [
        'id' => 1,
        'parent_id' => 2,
        'alias' => 'success',
        'title' => 'Success',
        'text' => '<p>Success Content</p>',
        'system' => 1,
    ],
    'parent' => [
        'id' => 2,
        'parent_id' => null,
        'alias' => 'course',
        'title' => 'Course',
        'text' => '<p>Course Content</p>',
        'system' => 0,
    ],
];
