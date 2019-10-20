<?php
/** @var $this AdminController */
/** @var $dataProvider CDataProvider */

use app\assets\CommentsAsset;
use app\components\AdminController;

/** @var $material CActiveRecord */
/** @var $dataPrvider CActiveDataProvider */

$this->pageTitle = 'Комментарии';

if (Yii::app()->moduleManager->allowed('blog')) {
    $this->admin[] = ['label' => 'Сообщения', 'url' => $this->createUrl('/contact/admin/contact/index')];
}

CommentsAsset::register(Yii::$app->view);
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

<?php $this->renderPartial('comment.views.admin.comment._list', ['dataProvider' => $dataProvider]); ?>


