<?php
$this->pageTitle='Блоки';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоки',
);

$this->admin[] = array('label'=>'Добавить блок', 'url'=>$this->createUrl('create'));
$this->info = 'Для вставки на страницу какого-либо сложного HTML-кода или скрипта создайте соответствующий блок и вставьте на страницу строкой [*block|id=псевдоним*]';

?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>HTML-Блоки</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>