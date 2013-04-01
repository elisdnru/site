
<div id="item_<?php echo $data->id; ?>">

    <div class="product_loop">
        <?php echo CHtml::beginForm(Yii::app()->createUrl('/shop/cart/add', array('id'=>$data->id))); ?>

        <p class="title"><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></p>

        <div class="image_block">

            <?php if ($data->firstImage): ?>
            <a href="<?php echo $data->url; ?>">
                <img src="<?php echo $data->firstImage->getThumbUrl(190, 190); ?>" />
            </a>
            <?php endif; ?>

        </div>

        <div class="product_info">

            <p class="text">
                Артикул:&nbsp;<?php echo CHtml::encode($data->artikul); ?>
                <br />Брэнд:&nbsp;<?php echo $data->brand ? CHtml::link(CHtml::encode($data->brand->title), $data->brand->url) : ''; ?>

                <?php foreach ($data->inshort_attribute_values as $attributeValue): ?>
                <?php if ($attributeValue->value): ?><br /><?php echo CHtml::encode($attributeValue->attribute->title); ?>:&nbsp;<?php echo CHtml::encode($attributeValue->value); ?><?php endif; ?>
                <?php endforeach; ?>
            </p>
            <p class="price">Цена: <?php echo number_format($data->price, 0, '.', ' '); ?> руб.</p>
            <p class="tocart"><?php echo CHtml::submitButton('В корзину' , array('onclick'=>'return toCartClick(' . $data->id . ')')); ?></p>

        </div>

        <?php echo CHtml::endForm(); ?>
        <a id="link<?php echo $data->id; ?>" class="inv tocartiframe" href="<?php echo Yii::app()->createUrl('/shop/cart/frame', array('id'=>$data->id, 'rand'=>md5(microtime()))); ?>"></a>

    </div>

</div>

<?php if ($index+1 % 2 == 0) : ?><div class="clear"></div><?php endif; ?>