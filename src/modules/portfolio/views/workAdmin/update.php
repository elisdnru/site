<?php
$this->pageTitle = 'Редактор работы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Просмотр', 'url' => $model->url];
$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/categoryAdmin/index')];

$this->info = 'Портфолио';
?>

    <h1>Редактирование работы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>