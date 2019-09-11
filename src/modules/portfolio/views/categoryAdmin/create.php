<?php
$this->pageTitle = 'Редактор категории портфолио';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['/portfolio/workAdmin/index'],
    'Категории' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('/portfolio/workAdmin/index')];

$this->info = 'Категории портфолио';
?>

<h1>Добавление категории портфолио</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
