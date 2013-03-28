<?php
$this->pageTitle='Мои заказы';
$this->breadcrumbs=array(
    'Мой профиль'=>$user->url,
    'Мои заказы'=>array('index'),
    'Заказ № ' . $model->getFullId() => array($this->createUrl('show', array('id'=>$model->id))),
    'Оплата',
);

if ($this->is(Access::ROLE_CONTROL))
{
    $this->admin[] = array('label'=>'Управление заказами', 'url'=>$this->createUrl('/shop/orderAdmin/index'));

    $this->info = 'Мои заказы';
}?>

<hr />

<h1>Оплата заказа</h1>

<?php if (!$model->payed) : ?>

    <p>Заказ будет помечен оплаченным только после того, как оператор получит ваш перевод. Оплачивать заказ несколько раз не нужно.</p>

    <?php if ($model->products): ?>

        <table>
            <tr>
                <th>Артикул</th>
                <th>Наименование</th>
                <th style="width:60px">Кол-во</th>
                <th style="width:100px">Цена</th>
                <th style="width:100px">Стоимость</th>
            </tr>

            <?php $total_count=0; $total_summ=0; ?>

            <?php foreach ($model->products as $product) : ?>
                <?php
                $total_count += $product->count;
                $total_summ += $product->count * $product->price;
                ?>
                <tr>
                    <td><?php echo $product->artikul; ?></td>
                    <td><?php echo $product->title; ?></td>
                    <td class="center"><?php echo $product->count; ?></td>
                    <td class="center"><?php echo number_format($product->price, 0, '.', ' '); ?> р</td>
                    <td class="center"><?php echo number_format($product->count * $product->price, 0, '.', ' '); ?> р</td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="2">Доставка: <?php echo $model->post_title; ?></td>
                <td></td>
                <td></td>
                <td class="center"><?php echo number_format($model->post_sum, 0, '.', ' '); ?> р</td>
            </tr>
            <tr>
                <th class="right" colspan="2">Итого с доставкой:</th>
                <th></th>
                <th></th>
                <th class="center"><?php echo number_format($total_summ + $model->post_sum, 0, '.', ' '); ?> р</th>
            </tr>

        </table>

    <?php endif; ?>

<?php else: ?>

<p>Этот заказ уже оплачен</p>

<?php endif; ?>
