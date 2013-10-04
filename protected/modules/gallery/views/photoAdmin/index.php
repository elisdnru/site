<?php
/* @var $this DAdminController */
/* @var $model GalleryPhoto */

$this->pageTitle='ЗФото и видео';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фото и видео',
);

$this->admin = array(
    array('label'=>'Добавить', 'url'=>$this->createUrl('create')),
    array('label'=>'Категории', 'url'=>$this->createUrl('/gallery/categoryAdmin/index')),
);
$this->info = 'Материалы галереи';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Фото и видео</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>