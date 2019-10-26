<?php
/** @var $this \yii\web\View */

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

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
?>

<h1>Добавление пользователя</h1>

<?= $this->render('_form', ['model' => $model]); ?>
