<?php
/** @var $this AdminController */
/** @var $dataProvider CDataProvider */

use app\assets\CommentsAsset;
use app\components\AdminController;

/** @var $material CActiveRecord */
/** @var $dataPrvider CActiveDataProvider */

$this->title = 'Комментарии';

if (Yii::$app->moduleManager->allowed('blog')) {
    $this->params['admin'][] = ['label' => 'Сообщения', 'url' => ['/contact/admin/contact/index']];
}

CommentsAsset::register(Yii::$app->view);
?>

<?php if ($material !== null) : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['index'],
        $material->title
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?= CHtml::encode($material->title) ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Панель управления' => ['/admin'],
        'Комментарии',
    ];
    ?>

    <div style="float:right">
        <?= CHtml::beginForm(['moderAll']) ?>
        <?= CHtml::submitButton('Пометить все новые почтёнными') ?>
        <?= CHtml::endForm() ?>
    </div>

    <h1>Комментарии</h1>

<?php endif; ?>

<?= $this->renderPartial('comment.views.admin.comment._list', ['dataProvider' => $dataProvider]); ?>


