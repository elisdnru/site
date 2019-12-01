<?php
use app\modules\landing\models\Landing;

/** @var $model Landing */

$this->title = 'Редактор лендингов';
$this->params['breadcrumbs'] = [
    'Лендинги' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Лендинги', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => $model->getUrl()];
if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Cтраницы', 'url' => ['/page/admin/page/index']];
}
?>

<h1>Редактирование лендинга</h1>

<?= $this->render('_form', ['model' => $model]) ?>

