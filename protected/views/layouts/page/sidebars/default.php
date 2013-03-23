<?php if ($this->route != 'user/default/login'): ?>
    <?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Личный кабинет'));?>
    <?php $this->widget('user.widgets.LoginFormWidget');?>
    <?php $this->endWidget();?>
<?php endif; ?>

<?php if ($this->menu): ?>
    <?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Управление'));?>
    <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu));?>
    <?php $this->endWidget();?>
<?php endif; ?>
