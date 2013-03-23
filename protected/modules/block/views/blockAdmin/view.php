<?php
$this->pageTitle = 'Блок ' . $model->title;
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоки'=>array('index'),
    $model->title,
);

$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Блоки', 'url'=>$this->createUrl('index'));
$this->info = 'Блоки';

?>

<h1>Просмотр блока &laquo;<?php echo CHtml::encode($model->title); ?>&raquo;</h1>

<?php echo $model->text; ?>