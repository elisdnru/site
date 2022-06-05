<?php

declare(strict_types=1);

return [
    'child' => [
        'id' => 1,
        'parent_id' => 2,
        'slug' => 'success',
        'title' => 'Success',
        'text' => '<p>Success Content</p>',
        'system' => 1,
    ],
    'parent' => [
        'id' => 2,
        'parent_id' => null,
        'slug' => 'course',
        'title' => 'Course',
        'text' => '<p>Course Content</p>',
        'system' => 0,
    ],
];
