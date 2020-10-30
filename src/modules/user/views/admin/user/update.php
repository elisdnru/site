<?php
/** @var $this View */

use app\modules\user\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var $model User */
/** @var $form ActiveForm */

$this->title = 'Редактирование данных пользователя';
$this->params['breadcrumbs'] = [
    'Пользователи' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование пользователя</h1>

<?= $this->render('_form', ['model' => $model]) ?>
