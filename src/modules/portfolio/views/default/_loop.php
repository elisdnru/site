<?php
/** @var $dataProvider ActiveDataProvider */
use app\modules\portfolio\models\Work;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<div id="worklist" class = "greed_container">
    <div class="items">
        <?php foreach ($dataProvider->getModels() as $work) : ?>
            <?php /** @var Work $work */ ?>
            <div class="entry greed">
                <p class="thumb">
                    <a href="<?= $work->getUrl() ?>" style="background-image: url('<?= $work->getImageThumbUrl(198) ?>')"><span><?= Html::encode($work->title) ?></span></a>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
]) ?>
