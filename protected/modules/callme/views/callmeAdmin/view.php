<?php
/* @var $this DAdminController */
/* @var $next Contact */
/* @var $prev Contact */

$this->pageTitle='Сообщение';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Заказы звонков'=>array('index'),
	'Заказ №'.$model->id,
);

$this->admin[] = array('label'=>'Заказы звонков', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Удалить', 'url'=>$this->createUrl('delete', array('id'=>$model->id)));

$this->info = 'Вы можете настроить отправку сообщений на свою почту в параметрах';
?>

<div style="float:right">
<?php echo CHtml::beginForm($this->createUrl('delete', array('id'=>$model->id))); ?>
<?php echo CHtml::submitButton('Удалить сообщение'); ?>
<?php echo CHtml::endForm(); ?>
</div>

<h1>Заказ звонка №<?php echo $model->id; ?></h1>

<p><?php echo $model->date; ?></p>
<table class="border">
    <tr><td>ФИО</td><td><?php echo CHtml::encode($model->name); ?></td></tr>
    <tr><td>Телефон</td><td><?php echo CHtml::encode($model->phone); ?></td></tr>
    <tr><td>Комментарий</td><td><?php echo nl2br(CHtml::encode($model->text)); ?></td></tr>
</table>
<?php if ($next): ?><p class="nomargin floatright"><a href="<?php echo $this->createUrl('view', array('id'=>$next->id)); ?>">следующее сообщение &rarr;</a></p><?php endif; ?>
<?php if ($prev): ?><p class="nomargin floatleft"><a href="<?php echo $this->createUrl('view', array('id'=>$prev->id)); ?>">&larr; предыдущее сообщение</a></p><?php endif; ?>

<div class="clear"></div>
