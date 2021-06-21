<?php declare(strict_types=1);

use app\components\DataProvider;
use app\modules\portfolio\models\Work;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Work> $dataProvider
 */
?>

<div class="grid-container">
    <div class="items">
        <?php foreach ($dataProvider->getItems() as $work) : ?>
            <div class="entry grid">
                <p class="thumb">
                    <a href="<?= $work->getUrl(); ?>" style="background-image: url('<?= $work->getImageThumbUrl(198); ?>')"><span><?= Html::encode($work->title); ?></span></a>
                </p>
            </div>
        <?php endforeach; ?>
        <div class="clear"></div>
    </div>
</div>

<?= LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
]); ?>
