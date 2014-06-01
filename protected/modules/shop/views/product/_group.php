<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<div class="product_page">

    <div class="image_block">

        <?php if ($model->firstImage): ?>
            <a class="lightbox" href="<?php echo $model->firstImage->imageUrl; ?>"><img id="preview_img" src="<?php echo $model->firstImage->getImageThumbUrl(300, 0); ?>" alt="<?php echo CHtml::encode(strip_tags($model->title)); ?>" /></a>
        <?php else: ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/images/nophoto.png" alt="" />
        <?php endif; ?>

        <?php if ($model->sale): ?>
            <span class="sale" title="Участвует в акции"></span>
        <?php endif; ?>

    </div>

    <div class="product_block">

        <?php if ($model->brand): ?>
            <p class="label">Брэнд: <span><?php echo CHtml::link(CHtml::encode($model->brand->title), $model->brand->url); ?></span></p>
        <?php endif; ?>

        <br />

        <?php Yii::app()->controller->widget('shop.components.ShopStarRating', array(
            'name' => 'rating_' . $model->id,
            'product' => $model,
            'cssFile'=>Yii::app()->theme->baseUrl . '/css/rating.css',
        )); ?>

    </div>

    <div class="clear"></div>

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
            <th style="width: 80px"></th>
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

            <td class="center" style="white-space: nowrap">
                <b><?php echo number_format($product->price, 0, '.', ' '); ?> р.</b>
            </td>

            <td>
                <?php echo CHtml::beginForm($this->createUrl('/shop/cart/add', array('id'=>$product->id)),'post'); ?>
                <p class="tocart_mini"><?php echo CHtml::submitButton('В корзину' , array('onclick'=>'return toCartClick(event, ' . $product->id . ')')); ?></p>
                <a id="link<?php echo $product->id; ?>" class="inv tocartiframe" href="<?php echo $this->createUrl('/shop/cart/frame', array('id'=>$product->id, 'rand'=>md5(microtime()))); ?>"></a>
                <?php echo CHtml::endForm(); ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </table>

    <div class="product_text">
        <?php echo $model->text_purified; ?>
    </div>

    <?php $this->widget('share.widgets.ShareWidget', array(
        'title'=>$model->title,
        'description'=>strip_tags($model->text),
        'image'=>$model->firstImage ? $model->firstImage->imageUrl : '',
    )); ?>

    <p><?php echo CHtml::link('&larr; Назад в каталог', $this->createUrl('/shop/default/index')); ?></p>

</div>