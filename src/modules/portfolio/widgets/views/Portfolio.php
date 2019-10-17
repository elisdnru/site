<?php
/** @var $items Work */

use app\assets\CarouselAsset;
use app\modules\portfolio\models\Work;

CarouselAsset::register(Yii::$app->view);
?>

<div class="portfolio ribbed">
    <div class="carousel_link carouselPrevLink"></div>
    <div class="carousel_link carouselNextLink"></div>
    <div class="portfolioSlider">
        <ul>
            <?php foreach ($items as $item) : ?>
                <li>
                    <a rel="nofollow" href="<?php echo $item->url; ?>"><span class="thumb" style="background-image: url('<?php echo $item->getImageThumbUrl(190, 0); ?>')"><span><?php echo CHtml::encode($item->title); ?></span></span></a>
                </li>
            <?php endforeach; ?>
            <li class="more">
                <a rel="nofollow" href="<?php echo Yii::app()->createUrl('/portfolio/default/index'); ?>">
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
        })
    })
})

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>
