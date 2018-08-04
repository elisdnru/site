<?php
$this->pageTitle='Новости';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости',
);

if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Новостные страницы', 'url'=>$this->createUrl('/new/pageAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Тематические группы', 'url'=>$this->createUrl('/new/groupAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Добавить новость', 'url'=>$this->createUrl('create'));

$this->info = 'Чтобы добавлять новости на любую страницу измените её тип на «Список материалов»';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Новости</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>