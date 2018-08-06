<?php
$this->pageTitle = 'Редактор атрибута';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Атрибуты' => ['index'],
    $model->label
];

$this->admin[] = ['label' => 'Атрибуты', 'url' => $this->createUrl('index')];

$this->info = 'Редактирование атрибута';
?>

<h1>Редактирование атрибута</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

