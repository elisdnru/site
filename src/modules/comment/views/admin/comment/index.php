<?php declare(strict_types=1);

use app\assets\CommentsAsset;
use app\components\DataProvider;
use app\modules\comment\models\Comment;
use app\modules\comment\models\Material;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Material|null $material
 * @var DataProvider<Comment> $dataProvider
 */
$this->title = 'Комментарии';

if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
    $this->params['admin'][] = ['label' => 'Посты', 'url' => ['/blog/admin/post/index']];
}

CommentsAsset::register($this);
?>

<?php if ($material !== null): ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Панель управления' => ['/admin/index'],
        'Комментарии' => ['index'],
        $material->getCommentTitle(),
    ];
    ?>

    <h1>Комментарии к материалу &laquo;<?= Html::encode($material->getCommentTitle()); ?>&raquo;</h1>

<?php else: ?>
    <?php
    $this->params['breadcrumbs'] = [
        'Комментарии',
    ];
    ?>

    <div style="float:right">
        <?= Html::beginForm(['moderAll']); ?>
        <?= Html::submitButton('Пометить все новые почтёнными'); ?>
        <?= Html::endForm(); ?>
    </div>

    <h1>Комментарии</h1>

<?php endif; ?>

<?= $this->render('@app/modules/comment/views/admin/comment/_list', ['dataProvider' => $dataProvider]); ?>


