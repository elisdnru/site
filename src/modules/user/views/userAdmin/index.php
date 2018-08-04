<?php
$this->pageTitle='Пользователи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Пользователи',
);

$this->admin[] = array('label'=>'Добавить пользователя', 'url'=>$this->createUrl('create'));

$this->info = 'Пользователи';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Пользователи</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
