
<?php if (count($items)) : ?>

<div class="shopcart">
    <table class="nomargin">
    <?php foreach ($items as $id=>$item) : ?>

    <?php if (!$item->model) continue; ?>

    <tr>
        <td><a href="<?php echo $item->model->url; ?>"><?php echo $item->model->title; ?></a></td>
        <td class="center"><?php echo $count; ?></td>
        <td style="width:16px"><a href="<?php echo Yii::app()->createUrl('/shop/cart/remove', array('id'=>$item->model->id)); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/core/images/admin/del.png" alt="Удалить" /></a></td>
    </tr>

    <?php endforeach; ?>
    </table>
    <hr style="margin:10px -10px 6px -10px !important" />
    <p class="tocart nomargin"><a href="<?php echo Yii::app()->createUrl('/shop/cart'); ?>">Перейти в корзину</a></p>
</div>

<?php else: ?>

    <p class="nomargin">Корзина пуста</p>

<?php endif; ?>