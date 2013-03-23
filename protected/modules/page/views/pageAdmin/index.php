<?php
$this->pageTitle='Страницы';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Страницы',
);

if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Добавить страницу', 'url'=>$this->createUrl('create'));
if ($this->moduleAllowed('menu')) $this->admin[] = array('label'=>'Пункты меню', 'url'=>$this->createUrl('/menu/menuAdmin/index'));
if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin/index'));

$this->info = 'После создания страницы Вы можете привязать её к любому пункту меню';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Страницы</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>