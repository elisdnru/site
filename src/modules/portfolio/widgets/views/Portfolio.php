<?php
/* @var $items PortfolioWork */
?>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<?php Yii::app()->clientScript->registerScript('/js/jcarousellite.min.js', CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/jcarousellite.min.js', CClientScript::POS_HEAD); ?>

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
            <li>
                <a rel="nofollow" href="<?php echo Yii::app()->createUrl('/portfolio/default/index'); ?>"><span class="thumb" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/portfolio.png')"></span></a>
            </li>
        </ul>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $(".portfolioSlider").jCarouselLite({
            circular: false,
            speed: 800,
            scroll: 2,
            visible: 4,
            btnNext: ".carouselNextLink",
            btnPrev: ".carouselPrevLink"
        });
    });
</script>
