<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;
use app\modules\user\models\User;

/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle = 'Редактирование данных пользователя';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Пользователи' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Пользователи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];

$this->info = 'Вы можете назначать администраторов';
?>

<h1>Редактирование пользователя</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

<hr />

<?php $this->renderPartial('_access', ['model' => $model]); ?>




