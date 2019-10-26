<?php
use yii\data\ActiveDataProvider;

/** @var $dataProvider ActiveDataProvider */
/** @var $query CActiveRecord */
?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $model) : ?>
        <?= $this->render('_view', [
            'data' => $model,
            'query' => $query,
        ]) ?>
    <?php endforeach; ?>
</div>
