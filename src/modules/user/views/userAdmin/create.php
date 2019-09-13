<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;

/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle = 'Пользователи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Пользователи' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Пользователи', 'url' => $this->createUrl('index')];

$this->info = 'Для добавления администратора выберите соответствующую роль';
?>

<h1>Добавление пользователя</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
