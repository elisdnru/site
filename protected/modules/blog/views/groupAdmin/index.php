<?php
/* @var $this DController */
/* @var $items BlogPostGroup[] */
/* @var $categoryForm BlogCategoryForm */
/* @var $form CActiveForm */

$this->pageTitle='Тематические группы записей';
$this->breadcrumbs=array(
	'Панель управления'=>array('/admin'),
	'Записи'=>array('/blog/postAdmin'),
	'Тематические группы',
);

$this->admin[] = array('label'=>'Записи', 'url'=>$this->createUrl('/blog/postAdmin/index'));
$this->admin[] = array('label'=>'Категории', 'url'=>$this->createUrl('/blog/categoryAdmin/index'));

$this->info = 'Нельзя удалить группу, пока в ней есть записи';
?>

<h1>Тематические группы записей</h1>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <table class="grid">
        <tr>
            <th>Наименование</th>
            <th width="50"></th>
            <th width="16"></th>
        </tr>
    <?php foreach($items as $item):

        $delurl = $this->createUrl('delete', array('id'=>$item->id));
        $newsurl = $this->createUrl('blog/postAdmin', array('BlogPost[group_id]'=>$item->id));

        ?>
        <tr id="item_<?php echo $item->id; ?>">
            <td><?php echo CHtml::activeTextField($item,"[$item->id]title", array('style'=>'width:99%', 'maxlength'=>255)); ?></td>
            <td class="center"><a href="<?php echo $newsurl; ?>">Записи</a></td>
            <td class="center"><?php if ($item->posts_count == 0) : ?><a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить группу &laquo;<?php echo CHtml::encode($item->title); ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a><?php endif; ?></td>
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
            <th>Наименование</th>
            <th width="16"></th>
        </tr>

        <tr>
            <td><?php echo $form->textField($categoryForm,'title', array('style'=>'width:99%', 'maxlength'=>255)); ?><br /></td>
            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить группу'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
