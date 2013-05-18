<?php
/* @var $this DAdminController */

$this->pageTitle='Метки записей';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Записи'=>array('/blog/postAdmin/index'),
	'Метки записей',
);

$this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin/index'));
$this->admin[] = array('label'=>'Группы', 'url'=>$this->createUrl('/blog/groupAdmin/index'));
$this->admin[] = array('label'=>'Добавить метку', 'url'=>$this->createUrl('create'));

$this->info = 'Метки записей';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Метки записей блога</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
