<?php
use app\assets\CarouselAsset;
use app\modules\portfolio\models\Work;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var Work[] $items
 */

CarouselAsset::register($this);
?>

<div class="portfolio ribbed">
    <div class="carousel_link carouselPrevLink"></div>
    <div class="carousel_link carouselNextLink"></div>
    <div class="portfolioSlider">
        <ul>
            <?php foreach ($items as $item) : ?>
                <li>
                    <a rel="nofollow" href="<?= $item->getUrl() ?>"><span class="thumb" style="background-image: url('<?= $item->getImageThumbUrl(190) ?>')"><span><?= Html::encode($item->title) ?></span></span></a>
                </li>
            <?php endforeach; ?>
            <li class="more">
                <a rel="nofollow" href="<?= Url::to(['/portfolio/default/index']) ?>">
                    <span class="thumb"></span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
<?php ob_start() ?>

jQuery(function($) {
    $(function () {
        $('.portfolioSlider').jCarouselLite({
            circular: false,
            speed: 800,
            scroll: 2,
            visible: 4,
            btnNext: '.carouselNextLink',
            btnPrev: '.carouselPrevLink'
        });
    });
});

<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>
