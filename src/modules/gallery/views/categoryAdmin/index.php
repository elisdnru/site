<?php
/* @var $this DAdminController */

$this->pageTitle='Категории галереи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фото и видео'=>array('/gallery/photoAdmin/index'),
	'Категории галереи',
);

$this->admin[] = array('label'=>'Материалы', 'url'=>$this->createUrl('/gallery/photoAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Категории галереи';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории галереи</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
