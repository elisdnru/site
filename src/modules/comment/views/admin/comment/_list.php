<?php

use app\components\DataProvider;
use app\modules\comment\models\Comment;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Comment> $dataProvider
 */
?>

<div class="items">
    <?php foreach ($dataProvider->getItems() as $data) : ?>
        <?= $this->render('@app/modules/comment/views/admin/comment/_view', ['data' => $data]) ?>
    <?php endforeach; ?>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
