<?php
$this->pageTitle = 'Редактор блоков';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Блоки', 'url' => $this->createUrl('index')];
$this->info = 'Блоки';

?>

<h1>Добавление блока</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
