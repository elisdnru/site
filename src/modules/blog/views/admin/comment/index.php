<?php
/** @var $this \yii\web\View */

use app\assets\CommentsAsset;
use app\modules\blog\models\Comment;

/** @var $material Comment */
/** @var $dataProvider CActiveDataProvider */

$this->title = 'Комментарии к записям';

if (Yii::$app->moduleManager->allowed('blog')) {
    $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
}
if ($material) {
    $this->params['admin'][] = ['label' => 'Перейти к записи', 'url' => $material->url];
}

CommentsAsset::register($this);
?>

<?php if ($material !== null) : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['/comment/admin/comment/index'],
        'Комментарии к записям' => ['index'],
        $material->title
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?= CHtml::encode($material->title) ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Комментарии' => ['/comment/admin/comment/index'],
        'Комментарии к записям',
    ];
    ?>

    <div style="float:right">
        <?= CHtml::beginForm(['moderAll']) ?>
        <?= CHtml::submitButton('Пометить все новые почтёнными') ?>
        <?= CHtml::endForm() ?>
    </div>

    <h1>Комментарии к записям</h1>

<?php endif; ?>

<?= $this->render('@app/modules/comment/views/admin/comment/_list', ['dataProvider' => $dataProvider]); ?>


