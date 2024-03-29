<?php

declare(strict_types=1);

use yii\rbac\Item;

return [
    'role_user' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Пользователь',
        'ruleName' => null,
        'data' => null,
    ],

    'permission_control' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Пользователь панели управления',
        'ruleName' => null,
        'data' => null,
    ],

    'permission_full' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Особый доступ',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_admin' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Панель управления',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_block' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Блоки',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_comment' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление комментариями',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_file' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление файлами',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_page' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление страницами',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_landing' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление лендингами',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_user' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление пользователями',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_blog' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление блогом',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'module_portfolio' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление портфолио',
        'ruleName' => null,
        'children' => [
            'permission_control',
        ],
        'data' => null,
    ],

    'role_manager' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Контент-менеджер',
        'children' => [
            'module_admin',
            'module_comment',
            'module_file',
            'module_page',
            'role_user',
        ],
        'ruleName' => null,
        'data' => null,
    ],

    'role_admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => [
            'permission_full',
            'module_admin',
            'module_block',
            'module_comment',
            'module_file',
            'module_page',
            'module_landing',
            'module_user',
            'module_blog',
            'module_portfolio',
            'role_user',
        ],
        'ruleName' => null,
        'data' => null,
    ],
];
