<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;

/* @var $material CActiveRecord */
/* @var $dataPrvider CActiveDataProvider */

$this->pageTitle = 'Комментарии';

if ($this->moduleAllowed('blog')) {
    $this->admin[] = ['label' => 'Сообщения', 'url' => $this->createUrl('/contact/contactAdmin/index')];
}

$this->info = 'Неопубликованные комментарии выделены серым, новые подсвечены';
?>

<?php if ($material !== null) : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['index'],
        $material->title
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?php echo CHtml::encode($material->title); ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin'],
        'Комментарии',
    ];
    ?>

    <div style="float:right">
        <?php echo CHtml::beginForm($this->createUrl('moderAll')); ?>
        <?php echo CHtml::submitButton('Пометить все новые почтёнными'); ?>
        <?php echo CHtml::endForm(); ?>
    </div>

    <h1>Комментарии</h1>

<?php endif; ?>

<?php $this->renderPartial('comment.views.commentAdmin._list', ['dataProvider' => $dataProvider]); ?>


