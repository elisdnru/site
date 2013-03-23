<?php
$this->pageTitle='Редактор блоков';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Блоки'=>array('index'),
	'Редактор',
);

$this->admin[] = array('label'=>'Блоки', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Просмотр', 'url'=>$this->createUrl('view', array('id'=>$model->id)));

$this->info = 'Блоки';

?>

<h1>Редактирование блока</h1>

<p class="note">Код для вставки этого блока на страницу: <b><?php echo Yii::app()->controller->DInlineWidgetsBehavior->startBlock; ?>block|id=<?php echo CHtml::encode($model->alias); ?><?php echo Yii::app()->controller->DInlineWidgetsBehavior->endBlock; ?></b></p>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
