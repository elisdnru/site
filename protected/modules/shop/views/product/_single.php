<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<div class="product_page">

    <?php if (Yii::app()->shopcart->get($model->id)): ?>
        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/index', array(),'get')); ?>
    <?php else: ?>
        <?php echo CHtml::beginForm($this->createUrl('/shop/cart/add', array('id'=>$model->id)),'post'); ?>
    <?php endif; ?>

    <h1><?php echo CHtml::encode($model->title); ?></h1>

    <div style="width:300px; float:left;">
        <?php if ($model->firstImage): ?>
            <a class="lightbox" href="<?php echo $model->firstImage->imageUrl; ?>"><img id="preview_img" src="<?php echo $model->firstImage->getImageThumbUrl(300, 0); ?>" alt="<?php //echo CHtml::encode(strip_tags($model->title)); ?>" /></a>
        <?php else: ?>
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/core/images/nophoto.png" alt="<?php //echo CHtml::encode($model->title); ?>" />
        <?php endif; ?>
    </div>

    <div style="margin-left:320px">

        <p class="artikul">Артикул: <span><?php echo CHtml::encode($model->artikul); ?></span></p>

        <br/>

        <?php foreach ($model->all_attribute_values as $attributeValue): ?>
            <?php if ($attributeValue->value): ?><p class="label"><?php echo CHtml::encode($attributeValue->attribute->title); ?>: <span><?php echo CHtml::encode($attributeValue->value); ?></span></p><?php endif; ?>
        <?php endforeach; ?>

        <p>&nbsp;</p>
        <p><span class="price"><?php echo number_format($model->price, 0, '.', ' '); ?> р</span></p>

        <?php if (Yii::app()->shopcart->get($model->id)): ?>
            <p class="tocart">&nbsp;Добавлено&nbsp; <?php echo CHtml::submitButton('Перейти в корзину', array('class'=>'button')); ?></p>
        <?php else: ?>
            <p class="tocart"><?php echo CHtml::textField('count', 1, array('size'=>3, 'class'=>'count')); ?> <?php echo CHtml::submitButton('Добавить в корзину', array('class'=>'button')); ?></p>
        <?php endif; ?>

        <a id="link<?php echo $model->id; ?>" class="inv tocartiframe" href="<?php echo $this->createUrl('/shop/cart/frame', array('id'=>$model->id, 'rand'=>md5(microtime()))); ?>"></a>

    </div>

    <div class="clear"></div>

    <div class="product_text">
        <?php echo $model->text_purified; ?>
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