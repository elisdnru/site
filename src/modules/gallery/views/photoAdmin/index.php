<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

$this->pageTitle = 'ЗФото и видео';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фото и видео',
];

$this->admin = [
    ['label' => 'Добавить', 'url' => $this->createUrl('create')],
    ['label' => 'Категории', 'url' => $this->createUrl('/gallery/categoryAdmin/index')],
];
$this->info = 'Материалы галереи';
?>

    <p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
    <h1>Фото и видео</h1>

<?php $this->renderPartial('_grid', ['model' => $model]); ?>