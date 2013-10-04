<?php

return array(

    'role_guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ),

    'role_user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children' => array(
            'role_guest',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'role_control' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Пользователь панели управления',
        'children' => array(
            'role_user',
        ),
        'bizRule' => null,
        'data' => null
    ),

    /* */

    'module_attribute' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Атрибуты',
        'bizRule' => null,
        'data' => null
    ),

    'module_admin' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Панель управления',
        'bizRule' => null,
        'data' => null
    ),

    'module_block' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Блоки',
        'bizRule' => null,
        'data' => null
    ),

    'module_booksru' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление книгами',
        'bizRule' => null,
        'data' => null
    ),

    'module_config' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление конфигурацией',
        'bizRule' => null,
        'data' => null
    ),

    'module_callme' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление заказанными звонками',
        'bizRule' => null,
        'data' => null
    ),
    'module_contact' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление сообщениями',
        'bizRule' => null,
        'data' => null
    ),

    'module_comment' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление комментариями',
        'bizRule' => null,
        'data' => null
    ),

    'module_file' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление файлами',
        'bizRule' => null,
        'data' => null
    ),

    'module_gallery' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление галереями',
        'bizRule' => null,
        'data' => null
    ),

    'module_newsgallery' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление галереями новостей',
        'bizRule' => null,
        'data' => null
    ),

    'module_menu' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление меню',
        'bizRule' => null,
        'data' => null
    ),

    'module_module' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление модулями',
        'bizRule' => null,
        'data' => null
    ),

    'module_new' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление новостями',
        'bizRule' => null,
        'data' => null
    ),

    'module_page' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление страницами',
        'bizRule' => null,
        'data' => null
    ),

    'module_personnel' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление сотрудниками',
        'bizRule' => null,
        'data' => null
    ),

    'module_recipe' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление рецептами',
        'bizRule' => null,
        'data' => null
    ),

    'module_review' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление отзывами',
        'bizRule' => null,
        'data' => null
    ),

    'module_rubricator' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление рубрикатором',
        'bizRule' => null,
        'data' => null
    ),

    'module_slideshow' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление слайдшоу',
        'bizRule' => null,
        'data' => null
    ),

    'module_user' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление пользователями',
        'bizRule' => null,
        'data' => null
    ),

    'module_userphoto' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление фоторграфиями пользователей',
        'bizRule' => null,
        'data' => null
    ),

    'module_blog' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление блогом',
        'bizRule' => null,
        'data' => null
    ),

    'module_portfolio' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление портфолио',
        'bizRule' => null,
        'data' => null
    ),

    'module_shop' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Управление магазином',
        'bizRule' => null,
        'data' => null
    ),

    /* */

    'role_manager' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Контент-менеджер',
        'children' => array(
            'role_control',
            'module_admin',
            'module_comment',
            'module_file',
            'module_gallery',
            'module_newsgallery',
            'module_menu',
            'module_new',
            'module_page',
            'module_personnel',
            'module_recipe',
            'module_review',
            'module_rubricator',
        ),
        'bizRule' => null,
        'data' => null
    ),

    'role_admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children' => array(
            'role_control',
            'module_admin',
            'module_attribute',
            'module_block',
            'module_booksru',
            'module_config',
            'module_callme',
            'module_contact',
            'module_comment',
            'module_file',
            'module_gallery',
            'module_newsgallery',
            'module_module',
            'module_menu',
            'module_new',
            'module_page',
            'module_personnel',
            'module_user',
            'module_meta',
            'module_blog',
            'module_portfolio',
            'module_shop',
            'module_recipe',
            'module_review',
            'module_rubricator',
            'module_slideshow',
            'module_userphoto',
        ),
        'bizRule' => null,
        'data' => null
    ),
);