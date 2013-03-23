<?php
$this->pageTitle='Мои заказы';
$this->breadcrumbs=array(
    'Мой профиль'=>$user->url,
    'Мои заказы',
);

if ($this->is(Access::ROLE_CONTROL)){

    $this->admin[] = array('label'=>'Управление заказами', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
    $this->info = 'Мои заказы';
} ?>

<h1>Мои заказы</h1>

<?php if(Yii::app()->user->hasFlash('order-form')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('order-form'); ?>
</div>

<?php endif; ?>

<table>
    <tr>
        <th style="width:100px">№</th>
        <th>Дата</th>
        <th style="width:180px">Оплачен</th>
        <th style="width:150px">Обработан</th>
        <th style="width:150px">Отправлен</th>
    </tr>

    <?php foreach ($orders as $order) : ?>

    <?php $url = $this->createUrl('show', array('id'=>$order->id)); ?>

    <tr>
        <td class="center"><a href="<?php echo $url; ?>"><?php echo $order->getFullId(); ?></a></td>
        <td class="center"><a href="<?php echo $url; ?>"><?php echo $order->date; ?></a></td>
        <td class="center"><?php if ($order->payed) : ?> <img src="/core/images/admin/yes.png" width="16" /> Оплачен<?php else : ?>Не оплачен<?php endif; ?>
        </td>
        <td class="center"><?php if ($order->apply) : ?><img src="/core/images/admin/yes.png" width="16" /> Обработан<?php else : ?>Не обработан<?php endif; ?></td>
        <td class="center"><?php if ($order->complete) : ?><img src="/core/images/admin/yes.png" width="16" /> Отправлен<?php else : ?>Не отправлен<?php endif; ?></td>
    </tr>
    <?php endforeach; ?>

</table>
    <br />