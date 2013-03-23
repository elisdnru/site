<?php
/* @var $this DAdminController */
/* @var $model ShopOrder */

$this->pageTitle='Заказ ' . $model->fullId;
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Заказы'=>array('index'),
    'Заказ ' . $model->fullId,
);

$this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
$this->admin[] = array('label'=>'Редактировать', 'url'=>$this->createUrl('update', array('id'=>$model->id)));

$this->info = 'Заказы';
?>

<p style="float:right"><a href="<?php echo $this->createUrl('update', array('id'=>$model->id)); ?>">Изменить данные</a></p>

<h1>Заказ <?php echo $model->fullId; ?></h1>

<?php if ($model->quickly): ?><p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/important.png'); ?> Срочный</p><?php endif; ?>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'itemTemplate'=>"<tr><td width='200'>{label}</td><td>{value}</td></tr>\n",
    'cssFile'=>false,
    'attributes'=>array(
        'date',
        array(
            'label'=>'Получатель',
            'value'=>$model->user ? CHtml::link(CHtml::encode($model->fio), CHtml::encode($model->user->url)) : CHtml::encode($model->fio),
            'type'=>'html',
        ),
        'phone',
        'email',
        'zip',
        'address',
        'posttitle',
        'postcode',
        array(
            'name'=>'comment',
            'value'=>nl2br(CHtml::encode($model->comment)),
            'type'=>'html',
        ),
    ),
));
?>

<br />

<table>
    <tr>
        <th>Артикул / Наименование</th>
        <th style="width:100px">Количество</th>
        <th style="width:100px">Цена</th>
        <th style="width:100px">Стоимость</th>
        <th style="width:100px">На складе</th>
        <th style="width:100px">Пожелание</th>
        <th style="width:20px"></th>
        <th style="width:20px"></th>
    </tr>
    <?php $total_count=0; $total_summ=0; ?>
    <?php foreach ($model->products as $product) : ?>
        <?php
        $total_count += $product->count;
        $total_summ += $product->count * $product->price;
        $delurl = $this->createUrl('/shop/orderProductAdmin/delete', array('id'=>$product->id));
        $editurl = $this->createUrl('/shop/orderProductAdmin/update', array('id'=>$product->id));
        ?>
        <tr id="product_<?php echo $product->id; ?>">
            <td>
                <?php if ($product->product): ?>
                <a href="<?php echo $product->product->url; ?>"><?php echo $product->artikul; ?> / <?php echo $product->title; ?></a>
                <?php else: ?>
                <?php echo $product->artikul; ?> / <?php echo $product->title; ?>
                <?php endif; ?>
            </td>
            <td class="center"><?php echo $product->count; ?></td>
            <td class="center"><?php echo number_format($product->price, 0, '.', ' '); ?> р</td>
            <td class="center"><?php echo $product->count * $product->price; ?> р</td>
            <td class="center"><?php echo $product->product->count; ?></td>
            <td class="center"><?php echo $product->comment; ?></td>
            <td class="center"><a href="<?php echo $editurl; ?>"><img src="/core/images/admin/edit.png" width="16" height="16" alt="Править" title="Править" /></a></td>
            <td class="center"><a class="ajax_del" data-del="product_<?php echo $product->id; ?>" title="Удалить товар &laquo;<?php echo $product->title; ?>&raquo; из заказа" href="<?php echo $delurl; ?>"><img src="/core/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a></td>

        </tr>
    <?php endforeach; ?>

    <tr>
        <th class="right" colspan="1">Итого:</th>
        <th class="center"><?php echo $total_count; ?></th>
        <th></th>
        <th class="center"><?php echo number_format($total_summ, 0, '.', ' '); ?> р</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>

    <tr>
        <td class="right" colspan="1">Доставка:</td>
        <td colspan="2"><?php echo $model->posttitle; ?></td>
        <td class="center"><?php echo $model->postsumm; ?> р</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th class="right" colspan="1">Итого с доставкой:</th>
        <th class="center"><?php echo $total_count; ?></th>
        <th></th>
        <th class="center">
            <?php echo number_format($total_summ + $model->postsumm, 0, '.', ' '); ?> р
        </th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</table>

<br />

<?php
$delurl = $this->createUrl('/shop/orderAdmin/delete', array('id'=>$model->id));
$toggle_apply = $this->createUrl('applied', array('id'=>$model->id));
$toggle_payed = $this->createUrl('payed', array('id'=>$model->id));
$toggle_complete = $this->createUrl('completed', array('id'=>$model->id));
?>

<div class="form" style="width:33%; float:left; margin-right:1%">
    <?php echo CHtml::beginForm($toggle_apply, 'post'); ?>
    <fieldset>
        <h3>Обработка</h3>
        <?php if ($model->apply): ?>
            <p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/yes.png'); ?> Принят</p>
        <?php else: ?>
            <p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/message.png'); ?> Не принят</p>
        <?php endif; ?>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->apply ? 'Отменить принятие в обработку' : 'Принять в обработку', array('class'=>'nomargin')); ?>
        </div>
    </fieldset>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="form" style="width:32%; float:left; margin-right:1%">
    <?php echo CHtml::beginForm($toggle_payed, 'post'); ?>
    <fieldset>
        <h3>Оплата</h3>
        <?php if ($model->payed): ?>
            <p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/yes.png'); ?> Оплачен</p>
        <?php else: ?>
            <p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/del.png'); ?> Не оплачен</p>
        <?php endif; ?>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->payed ? 'Снять пометку об оплате' : 'Пометить оплаченным', array('class'=>'nomargin')); ?>
        </div>
    </fieldset>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="form" style="width:33%; float:left;">
    <?php echo CHtml::beginForm($toggle_complete, 'post'); ?>
    <fieldset>
        <h3>Доставка</h3>
        <div class="row">
            <?php if ($model->complete): ?>
                <p><?php echo CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/yes.png'); ?> ID:<b> <?php echo CHtml::encode($model->postcode); ?></b></p>
            <?php else: ?>
                <p>
                <?php echo CHtml::textField('code', $model->postcode, array('size'=>50, 'class'=>'nomargin', 'placeholder'=>'Идентификатор почтового отпраления')); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->complete ? 'Отменить выполнение' : 'Пометить выполненным', array('class'=>'nomargin')); ?>
        </div>
    </fieldset>
    <?php echo CHtml::endForm(); ?>
</div>

<div class="clear"></div>

