<?php
/* @var $this DAdminController */
/* @var $model Contact */

$this->pageTitle='Сообщения';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Сообщения',
);

if ($this->moduleAllowed('comment')) $this->admin[] = array('label'=>'Комментарии', 'url'=>$this->createUrl('/comment/commentAdmin/index'));

$this->info = 'Отметка о прочтении выставляется автоматически';

?>

<h1>Сообщения</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>

