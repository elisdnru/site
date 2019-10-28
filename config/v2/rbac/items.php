<?php

use yii\rbac\Item;

return [

    'role_user' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Пользователь',
        'ruleName' => null,
        'data' => null
    ],

    'permission_control' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Пользователь панели управления',
        'children' => [
            'role_user',
        ],
        'ruleName' => null,
        'data' => null
    ],

    /* */

    'module_admin' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Панель управления',
        'ruleName' => null,
        'data' => null
    ],

    'module_block' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Блоки',
        'ruleName' => null,
        'data' => null
    ],

    'module_contact' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление сообщениями',
        'ruleName' => null,
        'data' => null
    ],

    'module_comment' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление комментариями',
        'ruleName' => null,
        'data' => null
    ],

    'module_file' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление файлами',
        'ruleName' => null,
        'data' => null
    ],

    'module_menu' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление меню',
        'ruleName' => null,
        'data' => null
    ],

    'module_page' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление страницами',
        'ruleName' => null,
        'data' => null
    ],

    'module_landing' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление лендингами',
        'ruleName' => null,
        'data' => null
    ],

    'module_user' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление пользователями',
        'ruleName' => null,
        'data' => null
    ],

    'module_blog' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление блогом',
        'ruleName' => null,
        'data' => null
    ],

    'module_portfolio' => [
        'type' => Item::TYPE_PERMISSION,
        'description' => 'Управление портфолио',
        'ruleName' => null,
        'data' => null
    ],

    /* */

    'role_manager' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Контент-менеджер',
        'children' => [
            'permission_control',
            'module_admin',
            'module_comment',
            'module_file',
            'module_menu',
            'module_new',
            'module_page',
        ],
        'ruleName' => null,
        'data' => null
    ],

    'role_admin' => [
        'type' => Item::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => [
            'permission_control',
            'module_admin',
            'module_block',
            'module_contact',
            'module_comment',
            'module_file',
            'module_menu',
            'module_page',
            'module_landing',
            'module_user',
            'module_blog',
            'module_portfolio',
        ],
        'ruleName' => null,
        'data' => null
    ],
];
