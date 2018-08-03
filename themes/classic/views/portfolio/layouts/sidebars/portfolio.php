
<?php if($this->beginCache(__FILE__.__LINE__, array('dependency'=>new Tags('block')))) { ?>
<?php $this->beginWidget('DPortlet', array('title' => 'Также я здесь'));?>
<?php $this->widget('follow.widgets.FollowWidget');?>
<?php $this->endWidget();?>
<?php $this->endCache(); } ?>

<?php if ($this->menu): ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Управление'));?>
    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu));?>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php if (Yii::app()->moduleManager->active('portfolio')): ?>

    <?php Yii::import('portfolio.models.PortfolioCategory'); ?>

    <?php $this->beginWidget('DPortlet', array('title' => 'Разделы портфолио'));?>
    <?php $this->widget('zii.widgets.CMenu', array('items' => PortfolioCategory::model()->cache(0, new Tags('portfolio'))->getMenuList(1000), 'htmlOptions'=>array('class'=>'collapsed')));?>
    <?php $this->endWidget();?>

<?php endif;?>
