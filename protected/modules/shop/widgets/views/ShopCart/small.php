<?php if (count($items)) : ?>
<?php  $total = 0; foreach ($items as $id=>$count) $total += $count; ?>
 | <a href="<?php echo Yii::app()->createUrl('/shop/cart'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/cart.png" />Корзина (<?php echo $total; ?>)</a>
<?php endif; ?>