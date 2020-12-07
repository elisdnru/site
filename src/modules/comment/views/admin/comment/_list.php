<?php

use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/** @var ActiveDataProvider $dataProvider */
?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $data) : ?>
        <?= $this->render('@app/modules/comment/views/admin/comment/_view', ['data' => $data]) ?>
    <?php endforeach; ?>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
