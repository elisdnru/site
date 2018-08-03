<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<div class="product_page">

    <?php if (Yii::app()->shopcart->get($model->id)): ?>
        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/index', array(),'get')); ?>
    <?php else: ?>
        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/add', array('id'=>$model->id)),'post'); ?>
    <?php endif; ?>

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

    <div class="description_block">

        <?php foreach ($model->all_attribute_values as $attributeValue): ?>
            <?php if ($attributeValue->value): ?><p class="label"><?php echo $attributeValue->attribute->title; ?>: <span><?php echo CHtml::encode($attributeValue->value); ?></span></p><?php endif; ?>
        <?php endforeach; ?>

        <br />

        <p><span class="price"><?php echo number_format($model->price, 0, '.', ' '); ?> р.</span></p>

        <p class="tocart"><?php echo CHtml::submitButton('В корзину' , array('onclick'=>'return toCartClick(event, ' . $model->id . ')')); ?></p>

        <a id="link<?php echo $model->id; ?>" class="inv tocartiframe" href="<?php echo $this->createUrl('/shop/cart/frame', array('id'=>$model->id, 'rand'=>md5(microtime()))); ?>"></a>

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

    <div class="product_text">
        <?php echo $model->text_purified; ?>
    </div>

    <?php $this->widget('share.widgets.ShareWidget', array(
        'title'=>$model->title,
        'description'=>strip_tags($model->text),
        'image'=>$model->firstImage ? $model->firstImage->imageUrl : '',
    )); ?>

    <p><?php echo CHtml::link('&larr; Назад в каталог', $this->createUrl('/shop/default/index')); ?></p>

    <?php echo CHtml::endForm(); ?>
</div>