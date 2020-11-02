<?php
use app\modules\landing\models\Landing;

/** @var $model Landing */

$this->title = 'Редактор лендингов';
$this->params['breadcrumbs'] = [
    'Лендинги' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Лендинги', 'url' => ['index']];
if (Yii::$app->moduleAccess->isGranted('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}
?>

<h1>Добавление лендинга</h1>

<?= $this->render('_form', ['model' => $model]) ?>

