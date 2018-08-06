<?php
$this->pageTitle = 'Редактор атрибута';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Атрибуты' => ['index'],
    'Добавление атрибута'
];

$this->admin[] = ['label' => 'Атрибуты', 'url' => $this->createUrl('index')];

$this->info = 'Добавление атрибута';
?>

<h1>Добавление атрибута</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

