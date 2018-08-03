<?php
$this->pageTitle = 'Корзина';
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    'Каталог'=>array('/shop'),
    'Корзина',
);

if ($this->is(Access::ROLE_CONTROL)){
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Заказы', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/create'));

    $this->info = 'Корзина';
}
?>

<?php
$total = 0;
$total_count = 0;
$total_summ = 0;
?>

<?php $this->beginWidget('DPortlet');?>

<div class="shopcart_page">

<?php echo CHtml::beginForm(); ?>

<div class="form">

    <table class="cart_table">

    <tr>
		<th>Наименование</th>
		<th style="width:140px">Количество</th>
        <th style="width:20px"></th>
        <th style="width:140px">Цена</th>
        <th style="width:140px">Сумма</th>
        <th style="width:18px"></th>
    </tr>

<?php foreach ($items as $id=>$item) : ?>


    <?php
    if (!$item->model){
        Yii::app()->shopcart->remove($id);
        continue;
    }
    $total_count += $item->count;
    $total_summ += $item->count * $item->model->price;
    ?>

    <tr>
		<td>
            <p><?php echo CHtml::link(CHtml::encode($item->model->title), $item->model->url); ?></p>
        </td>
        <td class="center count">
            <span class="diff minus">&ndash;</span>
            <?php echo CHtml::textField('Cart['.$id.'][count]', $item->count, array('size'=>3, 'class'=>'center count_' . $item->model->id)); ?>
            <span class="diff plus">+</span>
        </td>
        <td class="center"><?php echo CHtml::submitButton('Пересчитать'); ?></td>
        <td class="center price"><?php echo number_format($item->model->price, 0, '.', ' '); ?> руб</td>
        <td class="center price"><?php echo number_format($item->model->price * $item->count, 0, '.', ' '); ?> руб</td>
        <td class="center"><a class="confirm" title="Убрать элемент" href="<?php echo Yii::app()->createUrl('/shop/cart/remove', array('id'=>$id)); ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/remove.png" alt="Удалить" /></a></td>
    </tr>

<?php endforeach; ?>

    <tr>
        <th></th>
        <th class="center"><?php echo $total_count; ?></th>
        <th></th>
        <th></th>
        <th class="center price">
            <?php echo number_format($total_summ, 0, '.', ' '); ?> руб
        </th>
        <th></th>
    </tr>

</table>

</div>

<?php echo CHtml::endForm(); ?>

    <div class="clear"></div>

    <br />

<?php echo CHtml::beginForm(Yii::app()->createUrl('/shop/order')); ?>

<div class="form">
    <p style="float:left"><?php echo CHtml::link('&larr; Назад в каталог', $this->createUrl('/shop/default/index')); ?></p>
    <div class="row buttons right">
        <?php echo CHtml::submitButton('Перейти к оформлению заказа'); ?>
    </div>
</div>
    <?php echo CHtml::endForm(); ?>

</div>

<?php $this->endWidget(); ?>

<script>
    (function($){

         $('.cart_table td.count').each(function(){

             var field = $(this).find('input');
             var val = parseInt(field.val());

              $(this).find('.minus').click(function(){
                  val = val > 1 ? val - 1 : 1;
                  field.val(val);
              });

              $(this).find('.plus').click(function(){
                  val = val + 1;
                  field.val(val);
              });
         })

    })(jQuery);

</script>
