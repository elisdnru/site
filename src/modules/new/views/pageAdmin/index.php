<?php
$this->pageTitle='Новостные страницы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Новости'=>array('/new/newAdmin/index'),
	'Новостные страницы',
);

if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin/index'));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Тематические группы', 'url'=>$this->createUrl('/new/groupAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Добавить новостную страницу', 'url'=>$this->createUrl('create'));

$this->info = 'Чтобы добавлять новости на любую страницу добавьте её в этот список';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Новостные страницы</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>