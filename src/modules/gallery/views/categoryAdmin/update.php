<?php
/* @var $this DAdminController */
/* @var $model GalleryCategory */

$this->pageTitle = 'Редактор категории галереи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фото и видео' => ['/gallery/photoAdmin'],
    'Категории' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Материалы', 'url' => $this->createUrl('/gallery/photoAdmin/index')];
$this->info = '<p>Категории галереи</p>';

?>

<h1>Редактирование категории галереи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
