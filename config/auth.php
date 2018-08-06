<?php

return [

    'role_guest' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ],

    'role_user' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children' => [
            'role_guest',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'role_control' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Пользователь панели управления',
        'children' => [
            'role_user',
        ],
        'bizRule' => null,
        'data' => null
    ],

    /* */

    'module_attribute' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Атрибуты',
        'bizRule' => null,
        'data' => null
    ],

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

    'module_interest' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление интересным',
        'bizRule' => null,
        'data' => null
    ],

    'module_config' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление конфигурацией',
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

    'module_gallery' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление галереями',
        'bizRule' => null,
        'data' => null
    ],

    'module_newsgallery' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление галереями новостей',
        'bizRule' => null,
        'data' => null
    ],

    'module_menu' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление меню',
        'bizRule' => null,
        'data' => null
    ],

    'module_module' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление модулями',
        'bizRule' => null,
        'data' => null
    ],

    'module_new' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление новостями',
        'bizRule' => null,
        'data' => null
    ],

    'module_page' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление страницами',
        'bizRule' => null,
        'data' => null
    ],

    'module_review' => [
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление отзывами',
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
            'role_control',
            'module_admin',
            'module_comment',
            'module_file',
            'module_gallery',
            'module_newsgallery',
            'module_menu',
            'module_new',
            'module_page',
            'module_review',
        ],
        'bizRule' => null,
        'data' => null
    ],

    'role_admin' => [
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => [
            'role_control',
            'module_admin',
            'module_attribute',
            'module_block',
            'module_interest',
            'module_config',
            'module_contact',
            'module_comment',
            'module_file',
            'module_gallery',
            'module_newsgallery',
            'module_module',
            'module_menu',
            'module_new',
            'module_page',
            'module_user',
            'module_meta',
            'module_blog',
            'module_portfolio',
            'module_review',
        ],
        'bizRule' => null,
        'data' => null
    ],
];
