<?php
$this->pageTitle='Выпускники';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Выпускники',
);

$this->admin[] = array('label'=>'Классы', 'url'=>$this->createUrl('/graduate/gradeAdmin/index'));
$this->admin[] = array('label'=>'Добавить класс', 'url'=>$this->createUrl('/graduate/gradeAdmin/create'));
$this->admin[] = array('label'=>'Добавить выпускника', 'url'=>$this->createUrl('create'));
$this->admin[] = array('label'=>'Импорт выпускников', 'url'=>$this->createUrl('importList'));
$this->info = 'Сотрудники';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Выпускники</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>