<?php
/* @var $this DAdminController */
/* @var $material CActiveRecord */
/* @var $dataPrvider CActiveDataProvider */

$this->pageTitle='Комментарии';

if ($this->moduleAllowed('blog')) $this->admin[] = array('label'=>'Сообщения', 'url'=>$this->createUrl('/contact/contactAdmin/index'));

$this->info = 'Неопубликованные комментарии выделены серым, новые подсвечены';
?>

<?php if ($material !== null): ?>

<?php
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin/index'),
    'Комментарии'=>array('index'),
    $material->title
);
?>

<h1>Комментарии к материалу &laquo;<?php echo CHtml::encode($material->title); ?>&raquo;</h1>

<?php else: ?>

<?php
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Комментарии',
);
?>

<div style="float:right">
    <?php echo CHtml::beginForm($this->createUrl('moderAll')); ?>
    <?php echo CHtml::submitButton('Пометить все новые почтёнными'); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<h1>Комментарии</h1>

<?php endif; ?>

<?php if ($this->is(Access::ROLE_CONTROL)){

} ?>

<?php $this->renderPartial('comment.views.commentAdmin._list', array('dataProvider'=>$dataProvider)); ?>


