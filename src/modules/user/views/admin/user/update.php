<?php
/** @var $this \yii\web\View */

use app\modules\user\models\User;

/** @var $model User */
/** @var $form CActiveForm */

$this->title = 'Редактирование данных пользователя';
$this->params['breadcrumbs'] = [
    'Пользователи' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование пользователя</h1>

<?= $this->render('_form', ['model' => $model]); ?>
