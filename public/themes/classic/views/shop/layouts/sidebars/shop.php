
<?php if (Yii::app()->moduleManager->active('shop')): ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Корзина'));?>
        <div id="miniCartWidget"><?php $this->widget('shop.widgets.ShopCartWidget', array('tpl'=>'default')); ?></div>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php $this->beginWidget('DPortlet', array('title' => 'Профиль'));?>
    <?php $this->widget('user.widgets.LoginFormWidget');?>
<?php $this->endWidget();?>

<?php if (Yii::app()->moduleManager->active('shop')): ?>
    <?php Yii::import('shop.models.ShopCategory'); ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Ассортимент'));?>
        <?php $this->widget('zii.widgets.CMenu',array('items'=>ShopCategory::model()->cache(0, new Tags('shop'))->getMenuList(1000), 'activateParents'=>true, 'htmlOptions'=>array('class'=>'collapsed'))); ?>
    <?php $this->endWidget();?>
<?php endif; ?>
