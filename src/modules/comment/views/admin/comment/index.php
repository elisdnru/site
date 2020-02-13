<?php
/** @var $this View */
/** @var $dataProvider CDataProvider */

use app\assets\CommentsAsset;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

/** @var $material ActiveRecord */
/** @var $dataPrvider ActiveDataProvider */

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

    <h1>Комментарии к материалу &laquo;<?= Html::encode($material->title) ?>&raquo;</h1>

<?php else : ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Комментарии',
    ];
    ?>

    <div style="float:right">
        <?= Html::beginForm(['moderAll']) ?>
        <?= Html::submitButton('Пометить все новые почтёнными') ?>
        <?= Html::endForm() ?>
    </div>

    <h1>Комментарии</h1>

<?php endif; ?>

<?= $this->render('@app/modules/comment/views/admin/comment/_list', ['dataProvider' => $dataProvider]) ?>


