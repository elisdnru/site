<?php
$this->pageTitle = 'Редактор работы';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Работы', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/categoryAdmin/index')];
?>

<h1>Добавление работы</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
