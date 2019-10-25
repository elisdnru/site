<?php

return [

    'role_user' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'bizRule' => null,
        'data' => null
    ],

    'permission_control' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Пользователь панели управления',
        'children' => [
            'role_user',
        ],
        'bizRule' => null,
        'data' => null
    ],

    /* */

    'module_admin' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Панель управления',
        'bizRule' => null,
        'data' => null
    ],

    'module_block' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Блоки',
        'bizRule' => null,
        'data' => null
    ],

    'module_contact' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление сообщениями',
        'bizRule' => null,
        'data' => null
    ],

    'module_comment' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление комментариями',
        'bizRule' => null,
        'data' => null
    ],

    'module_file' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление файлами',
        'bizRule' => null,
        'data' => null
    ],

    'module_menu' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление меню',
        'bizRule' => null,
        'data' => null
    ],

    'module_page' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление страницами',
        'bizRule' => null,
        'data' => null
    ],

    'module_landing' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление лендингами',
        'bizRule' => null,
        'data' => null
    ],

    'module_user' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление пользователями',
        'bizRule' => null,
        'data' => null
    ],

    'module_blog' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление блогом',
        'bizRule' => null,
        'data' => null
    ],

    'module_portfolio' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление портфолио',
        'bizRule' => null,
        'data' => null
    ],

    /* */

    'role_manager' => [
        'type' => CAuthItem::TYPE_ROLE,
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
        'bizRule' => null,
        'data' => null
    ],

    'role_admin' => [
        'type' => CAuthItem::TYPE_ROLE,
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
        'bizRule' => null,
        'data' => null
    ],
];
