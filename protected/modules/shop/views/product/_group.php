<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<div class="product_page">


    <h1><?php echo CHtml::encode($model->title); ?></h1>

    <div style="width:300px; float:left;">
        <?php if ($model->firstImage): ?>
            <a class="lightbox" href="<?php echo $model->firstImage->imageUrl; ?>"><img id="preview_img" src="<?php echo $model->firstImage->getImageThumbUrl(300, 0); ?>" alt="<?php //echo CHtml::encode(strip_tags($model->title)); ?>" /></a>
        <?php else: ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/images/nophoto.png" alt="<?php //echo CHtml::encode($model->title); ?>" />
        <?php endif; ?>
    </div>

    <div style="margin-left:320px">

        <div class="product_text">
            <?php echo $model->text_purified; ?>
        </div>

    </div>

    <div class="photoslider" style="with:100%; overflow:auto;">
        <ul>
            <?php foreach ($model->images as $item) : ?>
                <li>
                    <a class="show_preview lightbox" rel="group" href="<?php echo $item->imageUrl; ?>">
                        <span style="background-image:url('<?php echo $item->getImageThumbUrl(100, 100); ?>')"></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

	<?php
	$attributes = array();
	foreach ($model->related_products as $product){
		if (!$product->public) continue;
		foreach ($product->all_attribute_values as $attributeValue){
			if (empty($attributes[$attributeValue->attribute_id]))
				$attributes[$attributeValue->attribute_id] = (bool)$attributeValue->value;
		}
	}
	?>

    <table>
        <tr>
            <th>Артикул</th>
            <?php foreach ($model->all_attribute_values as $attributeValue): ?>
				<?php if (!empty($attributes[$attributeValue->attribute_id])): ?>
                	<th><?php echo $attributeValue->attribute->title; ?></th>
				<?php endif; ?>
            <?php endforeach; ?>
            <th>Цена</th>
            <th></th>
        </tr>

        <?php foreach ($model->related_products as $product): ?>

            <?php if (!$product->public) continue; ?>

            <tr>
                <td><?php echo CHtml::encode($product->artikul); ?></td>

                <?php foreach ($product->all_attribute_values as $attributeValue): ?>
					<?php if (!empty($attributes[$attributeValue->attribute_id])): ?>
						<td class="center"><?php echo CHtml::encode($attributeValue->value); ?></td>
					<?php endif; ?>
                <?php endforeach; ?>

                <td style="white-space: nowrap">
                    <?php echo number_format($product->price, 0, '.', ' '); ?> р.
                </td>

                <td>
                    <?php if (Yii::app()->shopcart->get($model->id)): ?>
                        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/index', array(),'get')); ?>
                    <?php else: ?>
                        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/add', array('id'=>$model->id)),'post'); ?>
                    <?php endif; ?>

                    <?php if (Yii::app()->shopcart->get($model->id)): ?>
                        <p class="tocart">&nbsp;Добавлено&nbsp; <?php echo CHtml::submitButton('Перейти в корзину', array('class'=>'button')); ?></p>
                    <?php else: ?>
                        <p class="tocart"><?php echo CHtml::textField('count', 1, array('size'=>3, 'class'=>'count')); ?> <?php echo CHtml::submitButton('Добавить в корзину', array('class'=>'button')); ?></p>
                    <?php endif; ?>

                    <a id="link<?php echo $product->id; ?>" class="inv tocartiframe" href="<?php echo $this->createUrl('/shop/cart/frame', array('id'=>$product->id, 'rand'=>md5(microtime()))); ?>"></a>

                    <?php echo CHtml::endForm(); ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>

    <hr />
    <?php $this->widget('share.widgets.ShareWidget', array(
        'title'=>$model->title,
        'description'=>strip_tags($model->text),
        'image'=>$model->firstImage ? $model->firstImage->imageUrl : '',
    )); ?>

    <?php echo CHtml::endForm(); ?>

</div>

<script>
    jQuery("a.tocartiframe").colorbox({
        'transition' : 'none',
        'initialWidth' : 200,
        'initialHeight' : 120,
        'innerWidth' : 200,
        'innerHeight' : 120,
        'opacity' : 0.1,
        'iframe' : true
    });
</script>