<?php
$this->pageTitle = 'Редактор материала';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Новости' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Новости', 'url' => $this->createUrl('index')];

$this->info = 'В поле «Раздел» перечислены страницы с типом «Новости/Статьи»';
?>

<h1>Добавление новости</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
