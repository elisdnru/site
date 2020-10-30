<?php
/** @var $this View */

use app\modules\user\models\User;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var $model User */
/** @var $form ActiveForm */

$this->title = 'Пользователи';
$this->params['breadcrumbs'] = [
    'Пользователи' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Пользователи', 'url' => ['index']];
?>

<h1>Добавление пользователя</h1>

<?= $this->render('_form', ['model' => $model]) ?>
