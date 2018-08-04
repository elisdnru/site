<h1 style="font-family:arial; font-size:18px; font-weight:normal">Заказ <?php echo $order->fullId; ?><?php if ($order->quickly): ?> [Срочный]<?php endif; ?></h1>

<p style="font-family:arial; font-size:12px;"><b>Дата:</b> <?php echo $order->date; ?></p>

<p style="font-family:arial; font-size:12px;"><b>Получатель:</b> <?php echo $order->fio; ?><br />
    <b>Адрес:</b> <?php echo $order->zip; ?>, <?php echo $order->city; ?>, <?php echo $order->fullAddress; ?><br />
    <b>Телефон:</b> <?php echo $order->phone; ?><br />
    <b>Email:</b> <?php echo $order->email; ?><br />
    <b>Комментарий к заказу:</b> <?php echo $order->comment ? '<br />' . nl2br(strip_tags($order->comment)) : 'нет комментария'; ?></p>

<p style="font-family:arial; font-size:12px;">Если Вы зарегистрировались на сайте, то следить за своими заказами Вы можете в <a href="<?php echo Yii::app()->createAbsoluteUrl('user/orders'); ?>">личном кабинете</a>.</p>
<p style="font-family:arial; font-size:12px;">Для связи с администрацией сайта Вы можете ответить прямо на это письмо. Не изменяйте, пожалуйста, тему сообщения.</p>