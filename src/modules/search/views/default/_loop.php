<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $query CActiveRecord */
?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $model): ?>
        <?= $this->renderPartial('_view', [
            'data' => $model,
            'query' => $query,
        ]); ?>
    <?php endforeach; ?>
</div>
