<?php
/* @var $this DAdminController */

$this->pageTitle='Категории записей';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Записи'=>array('/blog/postAdmin/index'),
	'Категории записей',
);

$this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
$this->admin[] = array('label'=>'Группы', 'url'=>$this->createUrl('/blog/groupAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Категории записей';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Категории блога</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
