<?php

return array(
    'child_category' => array(
        'id' => 1,
        'sort' => 1,
        'alias' => 'category-1',
        'title' => 'Category 1',
        'parent_id' => 2,
    ),
    'parent_category' => array(
        'id' => 2,
        'sort' => 2,
        'alias' => 'category-2',
        'title' => 'Category 2',
        'parent_id' => 0,
    ),
    'category_with_posts' => array(
        'id' => 3,
        'sort' => 2,
        'alias' => 'category-3',
        'title' => 'Category 3',
        'parent_id' => 0,
    ),
    'category_without_posts' => array(
        'id' => 4,
        'sort' => 2,
        'alias' => 'category-4',
        'title' => 'Category 4',
        'parent_id' => 0,
    ),
);