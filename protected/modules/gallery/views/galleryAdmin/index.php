<?php
/* @var $this DAdminController */
/* @var $model Gallery */

$this->pageTitle='Фотогалереи';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Фотогалереи',
);
$this->admin[] = array('label'=>'Добавить фотогалерею', 'url'=>$this->createUrl('create'));

$this->info = 'Вы можете прикреплять галереи к новостям, выбирая нужную в списке при редактировании новости';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>

<h1>Фотогалереи</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>
