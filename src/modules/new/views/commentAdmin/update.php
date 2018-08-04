<?php
$this->pageTitle='Редактор комментариев';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Комментарии'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Комментарии', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));

$this->info = 'Комментарии';

?>

<h1>Редактирование комментария</h1>

<?php $this->renderPartial('comment.views.commentAdmin._form', array('model'=>$model)); ?>
