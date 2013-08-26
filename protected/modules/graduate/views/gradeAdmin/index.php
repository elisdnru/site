<?php
$this->pageTitle='Выпускные классы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники'=>array('/graduate/graduateAdmin/index'),
	'Классы',
);
$this->admin[] = array('label'=>'Выпускники', 'url'=>$this->createUrl('/graduate/graduateAdmin/index'));
$this->admin[] = array('label'=>'Добавить класс', 'url'=>$this->createUrl('create'));
$this->admin[] = array('label'=>'Импорт выпускников', 'url'=>$this->createUrl('/graduate/graduateAdmin/importList'));

$this->info = 'Выпускные классы';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Выпускные классы</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>