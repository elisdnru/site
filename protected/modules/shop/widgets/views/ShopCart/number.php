<?php if (count($items)) : ?>

    <?php
        $total_count = 0;
        $total_summ = 0;
        foreach ($items as $id=>$count) {
            $product = ShopProduct::model()->findByPk($id);
            if ($product){
                $total_summ += $count * $product->price;
                $total_count += $count;
            }
        }
        ?>

    <p><b>Ваш заказ</b></p>

    <p><?php echo $total_count; ?> <?php echo DNumberHelper::Plural($total_count, array('товар', 'товара', 'товаров')); ?> = <?php echo number_format($total_summ, 0, '.', ' '); ?> р.</p>

    <p><a href="<?php echo Yii::app()->createUrl('/shop/cart'); ?>">Перейти в корзину</a></p>

<?php else: ?>

    <p><b>Ваш заказ</b></p>

    <p>Корзина пуста</p>

<?php endif; ?>