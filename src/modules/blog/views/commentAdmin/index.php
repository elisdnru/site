<?php
/* @var $this DAdminController */

use app\modules\main\components\DAdminController;

/* @var $material BlogPostComment */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Комментарии к записям';

if ($this->moduleAllowed('blog')) {
    $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/postAdmin/index')];
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
        'Комментарии к записям' => ['index'],
        $material->title
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?php echo CHtml::encode($material->title); ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin'],
        'Комментарии' => ['/comment/commentAdmin/index'],
        'Комментарии к записям',
    ];
    ?>

    <div style="float:right">
        <?php echo CHtml::beginForm($this->createUrl('moderAll')); ?>
        <?php echo CHtml::submitButton('Пометить все новые почтёнными'); ?>
        <?php echo CHtml::endForm(); ?>
    </div>

    <h1>Комментарии к записям</h1>

<?php endif; ?>

<?php $this->renderPartial('comment.views.commentAdmin._list', ['dataProvider' => $dataProvider]); ?>


