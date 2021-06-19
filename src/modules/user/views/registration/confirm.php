<?php

declare(strict_types=1);

use yii\web\View;

/** @var View $this */
$this->context->layout = 'user';

$this->title = 'Подтверждение регистрации';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => ['default/login'],
    'Регистрация' => ['registration/request'],
    'Подтверждение регистрации',
];
