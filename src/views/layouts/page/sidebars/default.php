<?php if ($this->route != 'user/default/login'): ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Личный кабинет'));?>
    <?php $this->widget('user.widgets.LoginFormWidget');?>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php if ($this->menu): ?>
    <?php $this->beginWidget('DPortlet', array('title' => 'Управление'));?>
    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu));?>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php if($this->beginCache('banner_sidebar', array('dependency'=>new Tags('block')))) { ?>
    <?php $this->beginWidget('DPortlet', array('htmlOptions'=>array('class'=>'portlet banner')));?>
    <?php $this->widget('application.modules.block.widgets.BlockWidget', array('id'=>'banner_sidebar')); ?>
    <?php $this->endWidget(); ?>
<?php $this->endCache(); } ?>
