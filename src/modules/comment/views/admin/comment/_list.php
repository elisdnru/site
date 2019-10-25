<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */

use yii\widgets\LinkPager; ?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $data) : ?>
        <?php $this->renderPartial('comment.views.admin.comment._view', ['data' => $data]) ?>
    <?php endforeach; ?>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
