<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */

use yii\widgets\LinkPager; ?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $data) : ?>
        <?= $this->render('@app/modules/comment/views/admin/comment/_view', ['data' => $data]) ?>
    <?php endforeach; ?>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
