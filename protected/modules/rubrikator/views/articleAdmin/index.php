<?php
$this->pageTitle='Статьи рубрикатора';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Рубрикатор',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/rubrikator/categoryAdmin/index'));
$this->admin[] = array('label'=>'Добавить статью', 'url'=>$this->createUrl('create'));
$this->info = 'Статьи рубрикатора';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Статьи рубрикатора</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>