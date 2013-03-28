<?php
$this->pageTitle = 'Оформление заказа';
$this->description = '';
$this->keywords = '';

$this->breadcrumbs=array(
    'Каталог'=>array('/shop'),
    'Корзина'=>array('/shop/cart'),
    'Оформление заказа',
);

if ($this->is(Access::ROLE_CONTROL)){

    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Заказы', 'url'=>$this->createUrl('/shop/orderAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Товары', 'url'=>$this->createUrl('/shop/productAdmin/index'));
    if ($this->moduleAllowed('shop')) $this->admin[] = array('label'=>'Добавить товар', 'url'=>$this->createUrl('/shop/productAdmin/ceate'));

    $this->info = 'Здесь собраны работы из всех разделов';
} ?>

<?php
$total = 0;
$total_count = 0;
$total_summ = 0;
?>

<h1>Оформление заказа</h1>

<?php if (count($items)): ?>

<?php $this->beginWidget('DPortlet');?>

    <div class="shopcart_page">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'order-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>false,
            ),
        )); ?>

        <div class="form">
        <?php echo $form->errorSummary($order); ?>
        </div>

        <table>

            <tr>
                <th>Наименование</th>
                <th style="width:60px">К-во</th>
                <th style="width:60px">Цена</th>
                <th style="width:80px">Стоимость</th>
                <th style="width:150px">Примечание</th>
            </tr>

            <?php foreach ($items as $id=>$item) : ?>

            <?php
            if (!$item->model) continue;

            $total_count += $item->count;
            $total_summ += $item->count * $item->model->price;

            $comment = '';

            if (!empty($item->data['size']))
                $comment .= 'Размер ' . $item->data['size'] . ' ';

            if (!empty($item->data['color']))
                $comment .= 'Цвет ' . $item->data['color'] . ' ';

            ?>

            <tr>
                <td><a href="<?php echo $item->model->url; ?>"><?php echo $item->model->title; ?></a></td>
                <td class="center"><?php echo $item->count; ?></td>
                <td class="center price"><?php echo number_format($item->model->price, 0, '.', ' '); ?> р</td>
                <td class="center price"><?php echo number_format($item->count * $item->model->price, 0, '.', ' '); ?> р</td>
                <td><?php echo CHtml::textField('ShopOrder[product_comment][' . $item->hash . ']', $comment, array('size'=>20)); ?></td>
            </tr>

            <?php endforeach; ?>

            <tr>
                <th colspan="1" class="right">Итого</th>
                <th class="center"><?php echo $total_count; ?></th>
                <th></th>
                <th class="center price">
                    <?php echo number_format($total_summ, 0, '.', ' '); ?>р
                </th>
                <th></th>
            </tr>

        </table>

        <div class="form">

                <div class="row">
                    <?php echo $form->labelEx($order,'post_id'); ?><br />
                    <?php echo $form->dropDownList($order,'post_id',ShopPostType::model()->getAssocList(), array('style'=>'width:40ex')); ?>
                    <?php echo $form->error($order,'post_id'); ?>
                </div>

                <p>Вы можете заполнить данные в <a href="<?php echo $this->createUrl('/user/profile/index'); ?>">своём профиле</a>, чтобы они подставлялись в форму автоматически при последующих заказах:</p>

                <div class="row">
                    <?php echo $form->labelEx($order,'lastname'); ?><br />
                    <?php echo $form->textField($order,'lastname', array('size'=>40)); ?>
                    <?php echo $form->error($order,'lastname'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'name'); ?><br />
                    <?php echo $form->textField($order,'name', array('size'=>40)); ?>
                    <?php echo $form->error($order,'name'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'middlename'); ?><br />
                    <?php echo $form->textField($order,'middlename', array('size'=>40)); ?>
                    <?php echo $form->error($order,'middlename'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'phone'); ?><br />
                    <?php echo $form->textField($order,'phone', array('size'=>40)); ?>
                    <?php echo $form->error($order,'phone'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'email'); ?><br />
                    <?php echo $form->textField($order,'email', array('size'=>40)); ?>
                    <?php echo $form->error($order,'email'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'zip'); ?><br />
                    <?php echo $form->textField($order,'zip', array('size'=>40)); ?>
                    <?php echo $form->error($order,'zip'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'address'); ?><br />
                    <?php echo $form->textArea($order,'address', array('cols'=>60, 'rows'=>3)); ?>
                    <?php echo $form->error($order,'address'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($order,'comment'); ?><br />
                    <?php echo $form->textArea($order,'comment', array('cols'=>60, 'rows'=>3)); ?>
                    <?php echo $form->error($order,'comment'); ?>
                </div>

                <div class="row">
                    <?php echo $form->checkBox($order,'quickly'); ?>
                    <?php echo $form->labelEx($order,'quickly'); ?><br />
                    <?php echo $form->error($order,'quickly'); ?>
                </div>

                <br />

                <blockquote>
                    <?php echo nl2br(Yii::app()->config->get('SHOP.ORDER_AGREEMENT')); ?>
                </blockquote>

                <div class="row">
                    <?php echo $form->checkBox($order,'confirm'); ?>
                    <?php echo $form->labelEx($order,'confirm'); ?><br />
                    <?php echo $form->error($order,'confirm'); ?>
                </div>

                <br />

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Отправить заказ'); ?>
                </div>
            </div>

        <?php $this->endWidget(); ?>

    </div>

    <?php $this->endWidget(); ?>

<?php else: ?>

    <p><a href="<?php echo $this->createUrl('/shop'); ?>">Перейти в каталог</a></p>

<?php endif; ?>

<br />