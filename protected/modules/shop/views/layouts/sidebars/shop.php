<?php if (Yii::app()->moduleManager->active('shop')): ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Корзина'));?>
        <div id="miniCartWidget"><?php $this->widget('shop.widgets.ShopCartWidget', array('tpl'=>'default')); ?></div>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php if (Yii::app()->moduleManager->active('shop')): ?>
    <?php Yii::import('shop.models.ShopCategory'); ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Ассортимент'));?>
        <?php $this->widget('zii.widgets.CMenu',array('items'=>ShopCategory::model()->cache(3600)->getMenuList(1000), 'htmlOptions'=>array('class'=>'collapsed'))); ?>
    <?php $this->endWidget();?>
<?php endif; ?>
