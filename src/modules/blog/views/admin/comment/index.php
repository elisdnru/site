<?php
/* @var $this AdminController */

use app\modules\blog\models\Comment;
use app\components\AdminController;

/* @var $material Comment */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = 'Комментарии к записям';

if ($this->moduleAllowed('blog')) {
    $this->admin[] = ['label' => 'Записи', 'url' => $this->createUrl('/blog/admin/post/index')];
}
if ($material) {
    $this->admin[] = ['label' => 'Перейти к записи', 'url' => $material->url];
}

Yii::app()->clientScript->registerPackage('comments');
?>

<?php if ($material !== null) : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['/comment/admin/comment/index'],
        'Комментарии к записям' => ['index'],
        $material->title
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?php echo CHtml::encode($material->title); ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->breadcrumbs = [
        'Панель управления' => ['/admin'],
        'Комментарии' => ['/comment/admin/comment/index'],
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

<?php $this->renderPartial('comment.views.admin.comment._list', ['dataProvider' => $dataProvider]); ?>

