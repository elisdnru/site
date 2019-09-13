<?php if ($this->route != 'user/default/login') : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Личный кабинет']); ?>
    <?php $this->widget('user.widgets.LoginFormWidget'); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->menu) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget('application.modules.block.widgets.BlockWidget', ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif;
