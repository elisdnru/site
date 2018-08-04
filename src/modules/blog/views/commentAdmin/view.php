<?php
$this->pageTitle = 'Комментарий';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Комментарии'=>array('index'),
    'Комментарий',
);

$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Комментарии', 'url'=>$this->createUrl('index'));
$this->info = 'Комментарии';

?>

<h1>Просмотр комментария</h1>

<?php $this->renderPartial('comment.views.commentAdmin._view', array('data'=>$model)); ?>