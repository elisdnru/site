<?php
$this->pageTitle='Книги';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Книги',
);

$this->admin[] = array('label'=>'Добавить книгу', 'url'=>$this->createUrl('create'));
$this->info = 'Книги';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Книги</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>