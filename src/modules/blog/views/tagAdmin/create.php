<?php
/* @var $this DAdminController */
/* @var $model BlogTag */

$this->pageTitle = 'Редактор метки блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоги' => ['/blog/postAdmin'],
    'Метки' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin/index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')];
$this->admin[] = ['label' => 'Группы', 'url' => $this->createUrl('/blog/groupAdmin/index')];
$this->info = '<p>Категории блога</p>';
?>

<h1>Добавление категории блога</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
