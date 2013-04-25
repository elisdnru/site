
<div id="mainSlider">
    <ul>

<?php foreach ($products as $product): ?>

        <li>
            <div class="content">
                <div class="image">
                    <?php if ($product->firstImage): ?>
                    <p class="photo"><a href="<?php echo $product->url; ?>"><img src="<?php echo $product->firstImage->getImageThumbUrl(400, 250); ?>" alt="<?php echo CHtml::encode($product->title); ?>" /></a></p>
                    <?php endif; ?>
                    <p class="price"><span class="text"><?php echo CHtml::encode($product->price); ?> р</span><span class="corner"></span></p>
                </div>
                <div class="caption">
                    <p class="title"><?php echo CHtml::encode($product->title); ?></p>
                    <p class="text"><?php echo trim($product->short); ?></p>
                    <p class="link"><a href="<?php echo $product->url; ?>">Сделать заказ</a></p>
                </div>
                <div class="clear"></div>
            </div>
        </li>

        <?php endforeach; ?>

    </ul>
</div>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/slider.js"></script>
<script type="text/javascript">
    /* <![CDATA[ */
    jQuery('#mainSlider').milanSlider({
        loop: 5000,
        speed: 800
    });
    /* ]]> */
</script>