<?php
/* @var $this DAdminController */
/* @var $model BlogPost */

Yii::import('application.modules.gallery.models.*');

$this->pageTitle = 'Редактор записи блога';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Записи блога' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];
$this->admin[] = ['label' => 'Все записи', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/blog/categoryAdmin/index')];
$this->admin[] = ['label' => 'Править категорию', 'url' => $this->createUrl('/blog/categoryAdmin/update', ['id' => $model->category_id])];
$this->admin[] = ['label' => 'Метки', 'url' => $this->createUrl('/blog/tagAdmin/index')];
if ($this->moduleAllowed('newsgallery')) {
    $this->admin[] = ['label' => 'Галереи', 'url' => $this->createUrl('/newsgallery/galleryAdmin/index')];
}
?>

<h1>Редактирование записи</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>


