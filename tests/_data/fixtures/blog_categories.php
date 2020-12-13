<?php

return [
    'child_category' => [
        'id' => 1,
        'sort' => 1,
        'alias' => 'category-1',
        'title' => 'Category 1',
        'text' => '<p>Category 1</p>',
        'parent_id' => 2,
        'pagetitle' => '',
        'description' => '',
    ],
    'parent_category' => [
        'id' => 2,
        'sort' => 2,
        'alias' => 'category-2',
        'title' => 'Category 2',
        'text' => '<p>Category 2</p>',
        'parent_id' => null,
        'pagetitle' => 'Title 2',
        'description' => '',
    ],
    'category_with_posts' => [
        'id' => 3,
        'sort' => 2,
        'alias' => 'category-3',
        'title' => 'Category 3',
        'text' => '<p>Category 3</p>',
        'parent_id' => null,
        'pagetitle' => '',
        'description' => '',
    ],
    'category_without_posts' => [
        'id' => 4,
        'sort' => 2,
        'alias' => 'category-4',
        'title' => 'Category 4',
        'text' => '<p>Category 4</p>',
        'parent_id' => null,
        'pagetitle' => '',
        'description' => '',
    ],
];
