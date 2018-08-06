<?php
/* @var $this DAdminController */
/* @var $material GalleryPhotoComment */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Комментарии к фото и видео';

if ($this->moduleAllowed('gallery')) {
    $this->admin[] = ['label' => 'Материалы', 'url' => $this->createUrl('/gallery/photoAdmin/index')];
}
if ($material) {
    $this->admin[] = ['label' => 'Перейти к записи', 'url' => $material->url];
}

$this->info = 'Неопубликованные комментарии выделены серым, новые подсвечены';
?>

<?php if ($material !== null) : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['/comment/commentAdmin/index'],
        'Комментарии к фото и видео' => ['index'],
        $material->title ? $material->title : '#' . $material->id
    ];
    ?>

    <h1>Комментарии к материалу
        &laquo;<?php echo CHtml::encode($material->title ? $material->title : '#' . $material->id); ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin'],
        'Комментарии' => ['/comment/commentAdmin/index'],
        'Комментарии к фото и видео',
    ];
    ?>

    <div style="float:right">
        <?php echo CHtml::beginForm($this->createUrl('moderAll')); ?>
        <?php echo CHtml::submitButton('Пометить все новые почтёнными'); ?>
        <?php echo CHtml::endForm(); ?>
    </div>

    <h1>Комментарии к фото и видео</h1>

<?php endif; ?>

<?php if ($this->is(Access::ROLE_CONTROL)) {
} ?>

<?php $this->renderPartial('comment.views.commentAdmin._list', ['dataProvider' => $dataProvider]); ?>


