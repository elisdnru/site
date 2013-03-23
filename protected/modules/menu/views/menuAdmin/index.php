<?php
/* @var $this DAdminController */
/* @var $items Menu[] */

$this->pageTitle='Меню';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Меню',
);

if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));
$this->admin[] = array('label'=>'Добавить пункт', 'url'=>$this->createUrl('create'));

$this->info = 'Используйте псевдонимы, чтобы выводить нужные меню на страницу с помощью команды [*menu|parent=&lt;alias&gt;*]';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Пункты меню</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>