<?php
/* @var $model ShopOrder */

$this->pageTitle='Мои заказы';
$this->breadcrumbs=array(
    'Мой профиль'=>$user->url,
    'Мои заказы'=>array('/shop/orders'),
    'Заказ № ' . $model->fullId,
);

if ($this->is(Access::ROLE_CONTROL)){
    $this->admin[] = array('label'=>'Управление заказами', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
    $this->info = 'Мои заказы';
}
?>

<hr />

<h1>Заказ <?php echo $model->fullId; ?></h1>

<p>
    Оплачен: <?php if ($model->payed) : ?><img src="/core/images/admin/yes.png" width="16" /> да<?php else : ?>Нет<?php endif; ?><br />
    Обработан: <?php if ($model->apply) : ?><img src="/core/images/admin/yes.png" width="16" /> да<?php else : ?>Нет<?php endif; ?><br />
    Отправлен: <?php if ($model->complete) : ?><img src="/core/images/admin/yes.png" width="16" /> да<?php else : ?>Нет<?php endif; ?><br />
</p>

<table>
    <tr><th colspan="2"></th></tr>
    <tr><td width="200">Дата</td><td><?php echo $model->date; ?></td></tr>
    <tr><td>Получатель</td><td><?php echo $model->fio; ?></td></tr>
    <tr><td>Телефон</td><td><?php echo $model->phone; ?></td></tr>
    <tr><td>Email</td><td><?php echo $model->email; ?></td></tr>
    <tr><td>Адрес</td><td><?php echo $model->address; ?></td></tr>
    <tr><td>Доставка</td><td><?php echo $model->posttitle; ?></td></tr>
    <?php if ($model->complete && $model->postcode): ?>
    <tr><td>Идентификатор отправления</td><td><?php echo $model->postcode; ?></td></tr>
    <?php endif; ?>
    <tr><td>Комментарий</td><td><?php echo $model->comment ? nl2br(strip_tags($model->comment)) : 'нет'; ?></td></tr>
    <tr><th colspan="2"></th></tr>
</table>

<?php if ($model->products): ?>

    <br />

    <table>
        <tr>
            <th>Артикул</th>
            <th>Наименование</th>
            <th style="width:60px">Кол-во</th>
            <th style="width:80px">Цена</th>
            <th style="width:80px">Стоимость</th>
        </tr>

        <?php $total_count=0; $total_summ=0; ?>


        <?php foreach ($model->products as $product) : ?>
            <?php
            $total_count += $product->count;
            $total_summ += $product->count * $product->price;
            ?>
            <tr>
                <td style="white-space: nowrap">
                    <?php if ($product->product): ?>
                        <a target="_blank" href="<?php echo $product->product->url; ?>"><?php echo $product->artikul; ?></a>
                    <?php else: ?>
                        <?php echo $product->artikul; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <b><?php echo $product->title; ?></b>
                    <?php if ($product->comment): ?>
                        <br /><br><em><?php echo ($product->comment); ?></em>
                    <?php endif; ?>
                </td>
                <td class="center"><?php echo $product->count; ?></td>
                <td class="center"><?php echo number_format($product->price, 0, '.', ' '); ?></td>
                <td class="center"><?php echo number_format($product->count * $product->price, 0, '.', ' '); ?></td>
            </tr>
        <?php endforeach; ?>

        <tr>
            <th class="right" colspan="2">Итого:</th>
            <th class="center"><?php echo $total_count; ?></th>
            <th></th>
            <th class="center"><?php echo $total_summ; ?></th>
        </tr>
        <tr>
            <td colspan="2">Доставка: <?php echo $model->posttitle; ?></td>
            <td></td>
            <td></td>
            <td class="center"><?php echo number_format($model->postsumm, 0, '.', ' '); ?></td>
        </tr>
        <tr>
            <th class="right" colspan="2">Итого с доставкой:</th>
            <th></th>
            <th></th>
            <th class="center"><?php echo number_format($total_summ + $model->postsumm, 0, '.', ' '); ?></th>
        </tr>

    </table>

<?php endif; ?>
