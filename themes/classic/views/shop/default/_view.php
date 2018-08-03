<?php /* @var $data ShopProduct */ ?>

<div id="item_<?php echo $data->id; ?>">

    <div class="product_loop">
        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/add', array('id'=>$data->id))); ?>

        <p class="title"><a href="<?php echo $data->url; ?>"><?php echo CHtml::encode($data->title); ?></a></p>

        <div class="product_info">

            <p class="text">
                <?php echo CHtml::encode($data->short); ?><br /><br />

                <?php foreach ($data->inshort_attribute_values as $attributeValue): ?>
                <?php if ($attributeValue->value): ?><br /><b><?php echo CHtml::encode($attributeValue->attribute->title); ?>:</b>&nbsp;<?php echo CHtml::encode($attributeValue->value); ?><?php endif; ?>
                <?php endforeach; ?>
            </p>

            <p class="price"><?php echo number_format($data->price, 0, '.', ' '); ?> р</p>
            <p class="tocart"><?php echo CHtml::submitButton('В корзину', array('onclick'=>'return toCartClick(event, ' . $data->id . ')')); ?></p>

        </div>

        <?php echo CHtml::endForm(); ?>
        <a id="link<?php echo $data->id; ?>" class="inv tocartiframe" href="<?php echo $this->createUrl('/shop/cart/frame', array('id'=>$data->id, 'rand'=>md5(microtime()))); ?>"></a>

    </div>

</div>

<?php if ($index+1 % 4 == 0) : ?><div class="clear"></div><?php endif; ?>