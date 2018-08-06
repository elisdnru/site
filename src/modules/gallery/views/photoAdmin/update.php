<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle = 'Редактор фото или видео';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Фото или видео' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
$this->admin[] = ['label' => 'Все материалы', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/gallery/categoryAdmin/index')];
$this->admin[] = ['label' => 'Править категорию', 'url' => $this->createUrl('/gallery/categoryAdmin/update', ['id' => $model->category_id])];
?>

<h1>Редактирование фото или видео</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


