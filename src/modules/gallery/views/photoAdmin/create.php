<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle = 'Редактор материала галереи';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фото и видео' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Фото и видео', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/gallery/categoryAdmin/index')];

?>

<h1>Добавление фото или видео</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


