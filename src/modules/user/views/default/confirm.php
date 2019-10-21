<?php

$this->layout = '/layouts/user';

$this->title = 'Подтверждение регистрации';
$this->params['breadcrumbs'] = [
    'Вход на сайт' => $this->createUrl('login'),
    'Регистрация' => $this->createUrl('registration'),
    'Подтверждение регистрации'
];
?>

