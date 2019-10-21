<?php

/** @var $model \app\modules\portfolio\models\Category */

$this->title = 'Редактор категории портфолио';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
?>

<h1>Добавление категории портфолио</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
