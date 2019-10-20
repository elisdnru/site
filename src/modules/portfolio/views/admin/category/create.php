<?php

/** @var $model \app\modules\portfolio\models\Category */

$this->title = 'Редактор категории портфолио';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/admin/work/index'],
    'Категории' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/admin/work/index')];
?>

<h1>Добавление категории портфолио</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
