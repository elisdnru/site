<?php

declare(strict_types=1);

return [
    'child_category' => [
        'id' => 1,
        'sort' => 1,
        'slug' => 'category-1',
        'title' => 'Category 1',
        'text' => '<p>Category 1</p>',
        'parent_id' => 2,
        'meta_title' => '',
        'meta_description' => '',
    ],
    'parent_category' => [
        'id' => 2,
        'sort' => 2,
        'slug' => 'category-2',
        'title' => 'Category 2',
        'text' => '<p>Category 2</p>',
        'parent_id' => null,
        'meta_title' => 'Title 2',
        'meta_description' => '',
    ],
    'category_with_posts' => [
        'id' => 3,
        'sort' => 2,
        'slug' => 'category-3',
        'title' => 'Category 3',
        'text' => '<p>Category 3</p>',
        'parent_id' => null,
        'meta_title' => '',
        'meta_description' => '',
    ],
    'category_without_posts' => [
        'id' => 4,
        'sort' => 2,
        'slug' => 'category-4',
        'title' => 'Category 4',
        'text' => '<p>Category 4</p>',
        'parent_id' => null,
        'meta_title' => '',
        'meta_description' => '',
    ],
];
