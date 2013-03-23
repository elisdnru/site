<div id="seasonSliderBlock">

    <p class="nav"<?php if ($count < 3): ?> style="display:none"<?php endif; ?>>
        <span class="prev"></span>
        <span class="next"></span>
    </p>
    <div class="overflow">
        <div id="seasonSlider">
            <ul>

<?php foreach ($products as $product): ?>

        <li>
        <?php if ($product->firstImage): ?>
            <p class="photo"><a href="<?php echo $product->url; ?>"><img src="<?php echo $product->firstImage->getThumbUrl(400, 250); ?>" alt="" /></a></p>
            <?php endif; ?>
            <p class="title"><a href="<?php echo $product->url; ?>"><?php echo CHtml::encode($product->title); ?></a></p>
            <p class="price"><?php echo CHtml::encode($product->price); ?>.-</p>
            <p class="text"><?php echo trim($product->short); ?></p>
            <p class="link"><a href="<?php echo $product->url; ?>">Сделать заказ</a> &rarr;</p>
        </li>

        <?php endforeach; ?>

            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/core/js/jcarousellite.min.js"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    $('#seasonSlider').jCarouselLite({
        btnNext: '#seasonSliderBlock .next',
        btnPrev: '#seasonSliderBlock .prev',
        scroll: 1,
        speed: 600
    });
    /* ]]> */
</script>