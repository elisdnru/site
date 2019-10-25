<?php

use app\modules\landing\models\Landing;

/** @var $model Landing */
$this->title = 'Редактор лендингов';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Лендинги' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Лендинги', 'url' => $this->createUrl('index')];
if (Yii::app()->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page/index')];
}
?>

<h1>Добавление лендинга</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>

