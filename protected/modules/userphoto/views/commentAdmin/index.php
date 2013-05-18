<?php
/* @var $this DAdminController */
/* @var $material UserPhotoComment */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle='Комментарии к фотографиям';

if ($this->moduleAllowed('userphoto')) $this->admin[] = array('label'=>'Фотографии', 'url'=>$this->createUrl('/userphoto/photoAdmin/index'));
if ($material) $this->admin[] = array('label'=>'Перейти к фотографии', 'url'=>$material->url);

$this->info = 'Неопубликованные комментарии выделены серым, новые подсвечены';
?>

<?php if ($material !== null): ?>

<?php
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin/index'),
    'Комментарии'=>array('/comment/commentAdmin/index'),
    'Комментарии к фотографиям'=>array('index'),
    $material->title
);
?>

<h1>Комментарии к фотографии &laquo;<?php echo CHtml::encode($material->title); ?>&raquo;</h1>

<?php else: ?>

<?php
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Комментарии'=>array('/comment/commentAdmin/index'),
    'Комментарии к фотографиям',
);
?>

<div style="float:right">
    <?php echo CHtml::beginForm($this->createUrl('moderAll')); ?>
    <?php echo CHtml::submitButton('Пометить все новые почтёнными'); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<h1>Комментарии к фотографиям</h1>

<?php endif; ?>

<?php if ($this->is(Access::ROLE_CONTROL)){

} ?>

<?php $this->renderPartial('comment.views.commentAdmin._list', array('dataProvider'=>$dataProvider)); ?>


