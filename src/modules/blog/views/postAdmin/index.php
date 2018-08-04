<?php
/* @var $this DAdminController */
/* @var $model BlogPost */

$this->pageTitle='Записи блога';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Записи блога',
);

$this->admin = array(
    array('label'=>'Добавить', 'url'=>$this->createUrl('create')),
    array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin/index')),
    array('label'=>'Метки', 'url'=>$this->createUrl('/blog/tagAdmin/index')),
    array('label'=>'Тематические группы', 'url'=>$this->createUrl('/blog/groupAdmin/index')),
);
$this->info = 'Блоги';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>Записи блога</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>