<?php
/** @var $this \yii\web\View */
/** @var $dataProvider CDataProvider */

use app\assets\CommentsAsset;

/** @var $material CActiveRecord */
/** @var $dataPrvider CActiveDataProvider */

$this->title = 'Комментарии';

if (Yii::$app->moduleManager->allowed('blog')) {
    $this->params['admin'][] = ['label' => 'Сообщения', 'url' => ['/contact/admin/contact/index']];
}

CommentsAsset::register($this);
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

<?= $this->render('@app/modules/comment/views/admin/comment/_list', ['dataProvider' => $dataProvider]); ?>


