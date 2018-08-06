<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */

$this->pageTitle = 'Редактор фотогалереи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фотогалереи' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Фотогалереи', 'url' => $this->createUrl('index')];

$this->info = 'Фотогалереи';
?>

    <h1>Добавление фотогалереи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>