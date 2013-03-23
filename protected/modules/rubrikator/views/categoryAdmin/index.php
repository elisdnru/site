<?php
$this->pageTitle='Категории рубрикатора';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Рубрикатор'=>array('/rubrikator/articleAdmin/index'),
	'Категории рубрикатора',
);

$this->admin[] = array('label'=>'Статьи', 'url'=>$this->createUrl('/rubrikator/articleAdmin/index'));
$this->admin[] = array('label'=>'Добавить категорию', 'url'=>$this->createUrl('create'));

$this->info = 'Для каждого типа можно указать свои ватегории и атрибуты';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Категории рубрикатора</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>