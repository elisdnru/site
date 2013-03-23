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

<h1>Корзина</h1>
<div class="form">
<div class="shopcart_page">
<?php echo CHtml::beginForm(); ?>

<table>

    <tr>
        <th>Наименование</th>
        <th style="width:100px">Количество</th>
        <th style="width:100px">Цена</th>
        <th style="width:16px"></th>
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
        <td><a href="<?php echo $item->model->url; ?>"><?php echo $item->model->title; ?></a></td>
        <td class="center">
            <?php echo CHtml::textField('Cart['.$id.'][count]', $item->count, array('size'=>3, 'class'=>'center')); ?>
        </td>
        <td class="center price"><?php echo number_format($item->model->price, 0, '.', ' '); ?> р</td>
        <td style="width:16px"><a class="confirm" title="Убрать элемент" href="<?php echo Yii::app()->createUrl('/shop/cart/remove', array('id'=>$id)); ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/core/images/admin/del.png" alt="Удалить" /></a></td>
    </tr>

<?php endforeach; ?>

    <tr>
        <th colspan="1" class="right">Итого</th>
        <th class="center"><?php echo $total_count; ?></th>
        <th class="center price">
            <?php echo number_format($total_summ, 0, '.', ' '); ?> р
        </th>
        <th></th>
    </tr>

</table>

<div class="row buttons floatright">
    <?php echo CHtml::submitButton('Пересчитать'); ?> &nbsp;
    <a class="confirm" title="Убрать все товары из корзины" href="<?php echo Yii::app()->createUrl('/shop/cart/clear'); ?>">Очистить корзину</a>

</div>

<?php echo CHtml::endForm(); ?>

    <div class="clear"></div>

<?php echo CHtml::beginForm(Yii::app()->createUrl('/shop/order')); ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Перейти к оформлению заказа'); ?>
    </div>
<?php echo CHtml::endForm(); ?>

</div>
</div>
