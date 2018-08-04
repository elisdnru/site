<?php
/* @var $this DAdminController */
/* @var $items Config[] */

$this->pageTitle='Редактор параметров';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Параметры',
);

$this->admin[] = array('label'=>'Переоткрыть', 'url'=>$this->createUrl('admin/configs'));
$this->info = 'Если значение не указано, то используется значение по умолчанию';
?>

<h1>Параметры</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <table class="grid">

    <?php $prevGroup = ''; ?>

    <?php foreach($items as $item): ?>

        <?php
            $domens = explode('.' ,$item->param);
            $currGroup = array_shift($domens);
        ?>

        <?php if ($prevGroup != $currGroup): ?>

        </table>
            <br />
            <h2><?php echo $currGroup; ?></h2>

        <table class="grid" style="margin-bottom:20px !important">
        <tr>
            <th width="250">Параметр</th>
            <th>Значение</th>
        </tr>

        <?php endif; ?>


        <tr>
            <td><br /><?php echo $item->label; ?><br /><small>[<?php echo $item->param; ?>]</small><br /><br /></td>
            <td style="vertical-align: middle;">
                <?php if (!$item->type || $item->type == 'string'): ?>
                    <?php echo CHtml::activeTextField($item,"[$item->id]value", array('style'=>'width:99%', 'placeholder'=>$item->default)); ?>
                <?php elseif ($item->type == 'text'): ?>
                    <?php echo CHtml::activeTextArea($item,"[$item->id]value", array('rows'=>4, 'style'=>'width:99%', 'placeholder'=>$item->default)); ?>
                <?php elseif ($item->type == 'checkbox'): ?>
                    <?php echo CHtml::activeCheckBox($item,"[$item->id]value"); ?>
                <?php endif; ?>
            </td>
        </tr>

        <?php $prevGroup = $currGroup; ?>

    <?php endforeach; ?>

    </table>
    <div class="row buttons">
        <?php echo CHtml::resetButton('Сбросить ввод', array('class'=>'floatright')); ?>
        <?php echo CHtml::submitButton('Сохранить параметры'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->