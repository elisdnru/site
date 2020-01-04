<?php
/** @var $this View */

use app\assets\CommentsAsset;
use app\modules\blog\models\Comment;
use yii\helpers\Html;
use yii\web\View;

/** @var $material Comment */
/** @var $dataProvider CActiveDataProvider */

$this->title = 'Комментарии к записям';

if (Yii::$app->moduleManager->allowed('blog')) {
    $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
}
if ($material) {
    $this->params['admin'][] = ['label' => 'Перейти к записи', 'url' => $material->getUrl()];
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

    <h1>Комментарии к материалу &laquo;<?= Html::encode($material->title) ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Комментарии' => ['/comment/admin/comment/index'],
        'Комментарии к записям',
    ];
    ?>

    <div style="float:right">
        <?= Html::beginForm(['moderAll']) ?>
        <?= Html::submitButton('Пометить все новые почтёнными') ?>
        <?= Html::endForm() ?>
    </div>

    <h1>Комментарии к записям</h1>

<?php endif; ?>

<?= $this->render('@app/modules/comment/views/admin/comment/_list', ['dataProvider' => $dataProvider]) ?>


