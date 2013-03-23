<?php
$this->pageTitle='Способы доставки';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
    'Товары'=>array('/shop/productAdmin/index'),
	'Способы доставки',
);

$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/shop/categoryAdmin/index'));

$this->info = 'Способы доставки';
 ?>

<h1>Способы доставки</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <table class="grid">
        <tr>
            <th width="50">Позиция</th>
            <th>Наименование</th>
            <th>Стоимость, р</th>
            <th width="20"></th>
        </tr>
        <?php foreach($items as $item):

        $delurl = $this->createUrl('delete', array('id'=>$item->id));

        ?>
        <tr id="item_<?php echo $item->id; ?>">
            <td><?php echo CHtml::activeTextField($item,"[$item->id]sort", array('style'=>'width:50px', 'maxlength'=>255)); ?></td>
            <td><?php echo CHtml::activeTextField($item,"[$item->id]title", array('style'=>'width:99%', 'maxlength'=>255)); ?></td>
            <td><?php echo CHtml::activeTextField($item,"[$item->id]summ", array('style'=>'width:99%', 'maxlength'=>255)); ?></td>
            <td class="center"><a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить способ &laquo;<?php echo CHtml::encode($item->title); ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/core/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a></td>
        </tr>

        <?php endforeach; ?>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->

<br />
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'category-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <?php echo $form->errorSummary($categoryForm); ?>

    <table class="grid">
        <tr>
            <th width="50">Позиция</th>
            <th>Наименование</th>
            <th>Стоимость, р</th>
            <th width="20"></th>
        </tr>

        <tr>
            <td><?php echo $form->textField($categoryForm,'sort', array('style'=>'width:50px', 'maxlength'=>255, 'placeholder'=>'0')); ?></td>
            <td><?php echo $form->textField($categoryForm,'title', array('style'=>'width:99%', 'maxlength'=>255, 'placeholder'=>'Почта России')); ?></td>
            <td><?php echo $form->textField($categoryForm,'summ', array('style'=>'width:99%', 'maxlength'=>255, 'placeholder'=>'100')); ?></td>
            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить способ'); ?>
    </div>
    </fieldset>

    <?php $this->endWidget(); ?>

</div><!-- form -->
