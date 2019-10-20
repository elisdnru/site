<?php
/** @var $this AdminController */

use app\components\AdminController;
use app\modules\user\models\User;

/** @var $model User */
/** @var $form CActiveForm */

$this->title = 'Пользователи';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Пользователи' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => $this->createUrl('index')];
?>

<h1>Добавление пользователя</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
