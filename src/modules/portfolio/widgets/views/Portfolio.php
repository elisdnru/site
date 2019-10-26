<?php
/** @var $items Work */

use app\assets\CarouselAsset;
use app\modules\portfolio\models\Work;
use yii\web\View;

CarouselAsset::register($this);
?>

<div class="portfolio ribbed">
    <div class="carousel_link carouselPrevLink"></div>
    <div class="carousel_link carouselNextLink"></div>
    <div class="portfolioSlider">
        <ul>
            <?php foreach ($items as $item) : ?>
                <li>
                    <a rel="nofollow" href="<?= $item->url ?>"><span class="thumb" style="background-image: url('<?= $item->getImageThumbUrl(190, 0) ?>')"><span><?= CHtml::encode($item->title) ?></span></span></a>
                </li>
            <?php endforeach; ?>
            <li class="more">
                <a rel="nofollow" href="<?= Yii::app()->createUrl('/portfolio/default/index') ?>">
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
