<h1 style="font-family:arial; font-size:18px; font-weight:normal">Заказ <?php echo $order->getFullId(); ?></h1>

<p style="font-family:arial; font-size:12px;"><b>Дата:</b> <?php echo $order->date; ?></p>

<p style="font-family:arial; font-size:12px;"><b>Получатель:</b> <?php echo $order->fio; ?><br/>
    <b>Адрес:</b> <?php echo $order->fullAddress; ?><br/>
    <b>Телефон:</b> <?php echo $order->phone; ?><br/>
    <b>Email:</b> <?php echo $order->email; ?><br/>
    <b>Комментарий к заказу:</b><?php echo $order->comment ? '<br />' . nl2br(strip_tags($order->comment)) : ' нет'; ?>
</p>

<table style="border-collapse:collapse; font-family:arial; font-size:11px;" border="1" cellpadding="5">
    <tr>
        <th style="background:#eee;">Артикул</th>
        <th style="width:100px; background:#eee;">Количество</th>
        <th style="width:100px; background:#eee;">Цена</th>
        <th style="width:150px; background:#eee;">Стоимость</th>
        <th style="width:150px; background:#eee;">Пожелание</th>
    </tr>
    <?php $total_count = 0;
    $total_summ = 0; ?>
    <?php foreach ($order->products as $product) : ?>
        <?php
        $total_count += $product->count;
        $total_summ += $product->count * $product->price;

        ?>
        <tr>
            <td><?php echo $product->artikul; ?></td>
            <td style="text-align:center"><?php echo $product->count; ?></td>
            <td style="text-align:center"><?php echo $product->price; ?>р</td>
            <td style="text-align:center"><?php echo number_format($product->count * $product->price, 0, '.', ' '); ?>
                р
            </td>
            <td style="text-align:center"><?php echo $product->comment; ?></td>
        </tr>
    <?php endforeach; ?>

    <tr>
        <th style="text-align:right; background:#eee;" colspan="1">Итого:</th>
        <th style="text-align:center; background:#eee;"><?php echo $total_count; ?></th>
        <th style="background:#eee;"></th>
        <th style="text-align:center; background:#eee;"><?php echo number_format($total_summ, 0, '.', ' '); ?>р</th>
        <th style="background:#eee;"></th>
    </tr>

    <tr>
        <th style="text-align:right; background:#eee;" colspan="1">Доставка:</th>
        <th style="text-align:right; background:#eee;" colspan="2"><?php echo $order->post_title; ?></th>
        <th style="text-align:center; background:#eee;"><?php echo number_format($order->post_sum, 0, '.', ' '); ?>р
        </th>
        <th style="background:#eee;"></th>
    </tr>
    <tr>
        <th style="text-align:right; background:#eee;" colspan="1">Итого с доставкой:</th>
        <th style="text-align:center; background:#eee;"><?php echo $total_count; ?></th>
        <th style="background:#eee;"></th>
        <th style="text-align:center; background:#eee;">
            <?php echo number_format($total_summ + $order->post_sum, 0, '.', ' '); ?>р
        </th>
        <th style="background:#eee;"></th>
    </tr>
</table>

<p style="font-family:arial; font-size:12px;">Если Вы зарегистрировались на сайте, то следить за своими заказами Вы
    можете в <a href="<?php echo Yii::app()->createAbsoluteUrl('user/orders'); ?>">личном кабинете</a>.</p>
<p style="font-family:arial; font-size:12px;">Для связи с администрацией сайта Вы можете ответить прямо на это письмо.
    Не изменяйте, пожалуйста, тему сообщения.</p>
