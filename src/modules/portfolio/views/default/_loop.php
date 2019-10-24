<?php
/** @var $dataProvider CDataProvider */
use app\modules\portfolio\models\Work;
?>

<div id="worklist" class = "greed_container">
    <div class="items">
        <?php foreach ($dataProvider->getData() as $work) : ?>
            <?php /** @var Work $work */ ?>
            <div class="entry greed">
                <p class="thumb">
                    <a href="<?= $work->getUrl() ?>" style="background-image: url('<?= $work->getImageThumbUrl(198) ?>')"><span><?= CHtml::encode($work->title) ?></span></a>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
